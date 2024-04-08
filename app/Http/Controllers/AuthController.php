<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VerificationCode;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;

class AuthController extends Controller
{
    private function sendSms($to, $verificationCode)
    {
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET_KEY'));
        $client = new Client($basic);

        $message = "Hello!\n\n" . 
           "Your verification code is: $verificationCode. \n\n" . 
           "Please use this code to complete the verification process. \n\n" . 
           "Have a great day!";
        
        $response = $client->sms()->send(
            new SMS($to, 'brand', $message)
        );

        $message = $response->current();
    }

    public function sendVerificationCode($userPhone)
    {
        $verificationCode = mt_rand(1000, 9999);

        $user = User::where('phone', $userPhone)->first();

        VerificationCode::create([
            'phone' => $userPhone,
            'code' => $verificationCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // $this->sendSms($userPhone, $verificationCode); // Uncomment after setup Vonage service

        return response()->json(['message' => 'Verification code sent successfully'], 200);
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

        $this->sendVerificationCode($user->phone);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'phone' => 'required|integer',
            'password' => 'required|string',
        ]);

        if ($request->password == "") {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;

            $minutes = 30 * 24 * 60; // 30 days in minutes

            return response()->json(['message' => 'Authorization successful'], 200)
            ->cookie('access_token', $accessToken, $minutes);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();

        $accessToken->revoke();

        return response()->json(['message' => 'Logged out successfully'], 200);
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
            return response()->json(['error' => 'Invalid verification code'], 422);
        }

        if (Carbon::now()->gt($verificationCode->expires_at)) {
            return response()->json(['error' => 'Verification code has expired'], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->phone_verified_at = now();
        $user->save();

        $verificationCode->delete();

        return response()->json(['message' => 'Phone number verified successfully'], 200);
    }
}
