<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API for managing users"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user/getProfile",
     *     summary="Get user profile information",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="User profile information",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="User's name"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="User's last name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="User's email"
     *             ),
     *             @OA\Property(
     *                 property="date_of_birth",
     *                 type="string",
     *                 description="User's date of birth"
     *             ),
     *             @OA\Property(
     *                 property="photo",
     *                 type="string",
     *                 description="User's photo URL"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
     public function getProfile ()
     {
        //
     }

     /**
     * @OA\Post(
     *     path="/api/user/updateProfile",
     *     summary="Update user profile",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="User's name"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 description="User's phone number"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="User's last name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="User's email"
     *             ),
     *             @OA\Property(
     *                 property="date_of_birth",
     *                 type="string",
     *                 description="User's date of birth"
     *             ),
     *             @OA\Property(
     *                 property="photo",
     *                 type="string",
     *                 format="binary",
     *                 description="User's photo"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 description="Current password"
     *             ),
     *             @OA\Property(
     *                 property="new_password",
     *                 type="string",
     *                 description="New password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized"
     *     )
     * )
     */
     public function updateProfile(Request $request)
     {
        //
     }

     /**
     * @OA\Post(
     *     path="/api/admin/editUser",
     *     summary="Edit user profile (Admin)",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 description="User ID"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="User's name"
     *             ),
     *             @OA\Property(
     *                 property="last_name",
     *                 type="string",
     *                 description="User's last name"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 description="User's email"
     *             ),
     *             @OA\Property(
     *                 property="date_of_birth",
     *                 type="string",
     *                 description="User's date of birth"
     *             ),
     *             @OA\Property(
     *                 property="photo",
     *                 type="string",
     *                 format="binary",
     *                 description="User's photo"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied"
     *     )
     * )
     */
     public function adminEditUser(Request $request)
     {
        //
     }

     /**
     * @OA\Get(
     *     path="/api/admin/getBookingAgents",
     *     summary="Get all booking agents (Admin)",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="List of booking agents",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="User ID"
     *                         ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="User's first name"
     *                     ),
     *                     @OA\Property(
     *                         property="last_name",
     *                         type="string",
     *                         description="User's last name"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         type="string",
     *                         description="User's phone number"
     *                     ),
     *                     @OA\Property(
     *                         property="phone_verified_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user's phone number was verified"
     *                     ),
     *                     @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         description="User's password"
     *                     ),
     *                     @OA\Property(
     *                         property="role_id",
     *                         type="integer",
     *                         format="int32",
     *                         description="User's role ID"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         description="User's email address"
     *                     ),
     *                     @OA\Property(
     *                         property="date_of_birth",
     *                         type="string",
     *                         description="User's date of birth"
     *                     ),
     *                     @OA\Property(
     *                         property="photo",
     *                         type="string",
     *                         description="User's photo URL"
     *                     ),
     *                     @OA\Property(
     *                         property="remember_token",
     *                         type="string",
     *                         description="User's remember token"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user was created"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user was last updated"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied"
     *     )
     * )
     */
     public function adminGetBookingAgents()
     {
        //
     }

    /**
     * @OA\Get(
     *     path="/api/admin/getUsers",
     *     summary="Get all registered users without booking agents (Admin)",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="User ID"
     *                         ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="User's first name"
     *                     ),
     *                     @OA\Property(
     *                         property="last_name",
     *                         type="string",
     *                         description="User's last name"
     *                     ),
     *                     @OA\Property(
     *                         property="phone",
     *                         type="string",
     *                         description="User's phone number"
     *                     ),
     *                     @OA\Property(
     *                         property="phone_verified_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user's phone number was verified"
     *                     ),
     *                     @OA\Property(
     *                         property="password",
     *                         type="string",
     *                         description="User's password"
     *                     ),
     *                     @OA\Property(
     *                         property="role_id",
     *                         type="integer",
     *                         format="int32",
     *                         description="User's role ID"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         description="User's email address"
     *                     ),
     *                     @OA\Property(
     *                         property="date_of_birth",
     *                         type="string",
     *                         description="User's date of birth"
     *                     ),
     *                     @OA\Property(
     *                         property="photo",
     *                         type="string",
     *                         description="User's photo URL"
     *                     ),
     *                     @OA\Property(
     *                         property="remember_token",
     *                         type="string",
     *                         description="User's remember token"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user was created"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the user was last updated"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied"
     *     )
     * )
     */
    public function adminGetUsers()
    {
       //
    }

    /**
     * @OA\Get(
     *     path="/api/user/getUserBookings",
     *     summary="Get bookings for the authenticated user",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="List of bookings for the user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bookings",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Booking ID"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         format="int64",
     *                         description="User ID"
     *                     ),
     *                     @OA\Property(
     *                         property="object_id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Object ID"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_from",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was reserved"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_to",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was reserved"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_from",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was booked"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_to",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was booked"
     *                     ),
     *                     @OA\Property(
     *                         property="peyment_status",
     *                         type="boolean",
     *                         description="Booking status"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was created"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the booking was last updated"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="No bookings found"
     *     )
     * )
     */
    public function getUserBookings()
    {
        //
    }
}
