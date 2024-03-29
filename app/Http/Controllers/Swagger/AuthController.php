<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="API for authentication"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="User's phone number"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="User's password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Authorization successful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Authorization successful"
     *             )
     *         ),
     *         @OA\Header(
     *             header="Set-Cookie",
     *             description="Access token cookie",
     *             @OA\Schema(
     *                 type="string",
     *                 example="access_token=abc123; Expires=Wed, 21 Oct 2020 07:28:00 GMT; Max-Age=2592000; Path=/"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthorized"
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="User logout",
     *     tags={"Auth"},
     *     security={{"passport": {}}},
     *     @OA\Response(
     *         response="200",
     *         description="Logged out successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Logged out successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     summary="User registration",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="User's first name"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="User's last name"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="User's phone number",
     *                 format="phone",
     *                 uniqueItems=true
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="User's password",
     *                 format="password",
     *                 minLength=8
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="User registered successfully"
     *             )
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/auth/verify",
     *     summary="Verify user's phone number",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="User's phone number"
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 type="integer",
     *                 description="Verification code"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Phone number verified successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Phone number verified successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Invalid verification code",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid verification code"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="User not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="423",
     *         description="Verification code has expired",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Verification code has expired"
     *             )
     *         )
     *     )
     * )
     */
    public function verify(Request $request)
    {
        //
    }
}
