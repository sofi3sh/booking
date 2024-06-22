<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VerificationCode;
// use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;

use GuzzleHttp\Client;

class AuthController extends Controller
{

    private function createAndSendVerificationCode($userPhone)
    {
        $verificationCode = mt_rand(1000, 9999);

        $user = User::where('phone', $userPhone)->first();

        VerificationCode::create([
            'phone' => $userPhone,
            'code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $this->sendSms($userPhone, $verificationCode);
    }

    public function sendVerificationCode (Request $request)
    {
        $request->validate([
            'phone' => 'required|integer',
        ]);

        $this->createAndSendVerificationCode($request->phone);

        return response()->json(['message' => __('verification_code_sent_successfully')], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|integer|unique:users,phone',
            'password' => 'required|string|min:8',
        ]);

        $user = new User([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 3,
        ]);

        $user->save();

        $this->createAndSendVerificationCode($user->phone);

        return response()->json(['message' => __('user_registered_successfully')], 201);
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'phone' => 'required|integer',
            'password' => 'required|string',
        ]);

        if ($request->password == "") {
            return response()->json(['message' => __('unauthorized')], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_blocked) {
                return response()->json(['message' => __('permission_denied')], 403);
            }

            $accessToken = $user->createToken('authToken')->accessToken;

            $minutes = 30 * 24 * 60; // 30 days in minutes

            // To see required params
            // cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null)

            return response()->json(['message' => __('authorization_successful')], 200)
                ->cookie('access_token', $accessToken, $minutes, '/', '.booking.siteweb.org.ua', true, false, false, 'None');
        }

        return response()->json(['message' => __('unauthorized')], 401);
    }

    public function logout()
    {
        Auth::user()->token()->revoke();

        return response()->json(['message' => __('logged_out_successfully')], 200);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required|integer',
            'code' => 'required|integer',
        ]);

        $verificationCode = VerificationCode::where('phone', $request->phone)
            ->where('code', $request->code)
            ->first();

        if (!$verificationCode) {
            return response()->json(['error' => __('invalid_verification_code')], 422);
        }

        if (Carbon::now()->gt($verificationCode->expires_at)) {
            return response()->json(['error' => __('expired_verification_code')], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['error' => __('user_not_found')], 404);
        }

        $user->phone_verified_at = now();
        $user->save();

        $verificationCode->delete();

        return response()->json(['message' => __('success_verification_code')], 200);
    }

    public function sendSms($to, $verificationCode)
    {
        $baseUrl = 'https://a2p.vodafone.ua';
        $username = '380956139029';
        $password = 'STRe456892-=wr';

        $message = __('verification_code') . ' ' . $verificationCode;

        $client = new \GuzzleHttp\Client();

        try {


            $response = $client->post("{$baseUrl}/uaa/oauth/token", [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => $username,
                    'password' => $password,
                ],
                'headers' => [
                    'Authorization' => 'Basic aW50ZXJuYWw6aW50ZXJuYWw=',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];


            $response = $client->post("{$baseUrl}/communication-event/api/communicationManagement/v2/communicationMessage/send", [
                'json' => [
                    'content' => $message,
                    'type' => 'SMS',
                    'receiver' => [
                        [
                            'id' => 0,
                            'phoneNumber' => $to
                        ]
                    ],
                    'sender' => [
                        'id' => 'Pool Beach',
                        'name' => 'Pool Beach',
                        'phoneNumber' => '380956139029'
                    ],
                    'characteristic' => [
                        [
                            'name' => 'DISTRIBUTION.ID',
                            'value' => '5840964'
                        ],
                        [
                            'name' => 'VALIDITY.PERIOD',
                            'value' => '000000000900000R'
                        ]
                    ]
                ],
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
            ]);
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return response()->json([
                'error' => $responseBodyAsString,
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
