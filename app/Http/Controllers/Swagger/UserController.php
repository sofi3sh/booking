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
     *                 property="id",
     *                 type="integer",
     *                 description="User's ID"
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="User's phone"
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
     *                 description="User's photo URL"
     *             ),
     *             @OA\Property(
     *                 property="role_id",
     *                 type="integer",
     *                 description="User role ID",
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
     *             ),
     *             @OA\Property(
     *                 property="lang",
     *                 type="string",
     *                 description="Specify language",
     *                 format="lang"
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
 * @OA\Get(
 *     path="/api/user/getUserBookings",
 *     summary="Get user bookings",
 *     tags={"Users"},
 *     @OA\Response(
 *         response="200",
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="bookings",
 *                 type="object",
 *                 additionalProperties=@OA\Property(
 *                     type="array",
 *                     @OA\Items(
 *                         @OA\Property(
 *                             property="id",
 *                             type="integer",
 *                             description="Unique identifier for the booking"
 *                         ),
 *                         @OA\Property(
 *                             property="user_id",
 *                             type="integer",
 *                             description="User id"
 *                         ),
 *                         @OA\Property(
 *                             property="object_id",
 *                             type="integer",
 *                             description="Object id"
 *                         ),
 *                         @OA\Property(
 *                             property="booked_from",
 *                             type="string",
 *                             format="date-time",
 *                             description="Booked from"
 *                         ),
 *                         @OA\Property(
 *                             property="booked_to",
 *                             type="string",
 *                             format="date-time",
 *                             description="Booked to"
 *                         ),
 *                         @OA\Property(
 *                             property="payment_status",
 *                             type="boolean",
 *                             description="Payment status"
 *                         ),
 *                         @OA\Property(
 *                             property="canceled",
 *                             type="boolean",
 *                             description="Is booking canceled"
 *                         ),
 *                         @OA\Property(
 *                             property="description",
 *                             type="string",
 *                             description="Description"
 *                         ),
 *                         @OA\Property(
 *                             property="price",
 *                             type="string",
 *                             description="Price"
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="404",
 *         description="No bookings found",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="No bookings found"
 *             )
 *         )
 *     )
 * )
 */
public function getUserBookings ()
{
    //
}

   /**
     * @OA\Post(
     *     path="/api/user/resetPassword",
     *     summary="To set a new password, users must undergo re-verification. This process should be completed within 5 minutes",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="new_password",
     *                 type="string",
     *                 description="New password"
     *             ),
     *             @OA\Property(
     *                 property="lang",
     *                 type="string",
     *                 description="Specify language",
     *                 format="lang"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Password changed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Password changed successfully",
     *                 example="Password changed successfully"
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
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="You need to confirm your phone number",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="You need to confirm your phone number"
     *             )
     *         )
     *     )
     * )
     */
    public function resetPassword ()
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
     *             ),
     *             @OA\Property(
     *                 property="role_id",
     *                 type="integer",
     *                 description="User's role ID"
     *             ),
     *             @OA\Property(
     *                 property="lang",
     *                 type="string",
     *                 description="Specify language",
     *                 format="lang"
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
    * @OA\Post(
    *     path="/api/admin/adminBlockUser",
    *     summary="Block user (Admin)",
    *     tags={"Users"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(
    *                 property="user_id",
    *                 type="integer",
    *                 description="User ID"
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
    public function adminBlockUser(Request $request)
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
     * @OA\Post(
     *     path="/api/admin/getUserByPhone",
     *     summary="Get user by phone number (Admin)",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="Phone number"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     format="int64",
     *                     description="User ID"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="User's first name"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     description="User's last name"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     description="User's phone number"
     *                 ),
     *                 @OA\Property(
     *                     property="phone_verified_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Timestamp when the user's phone number was verified"
     *                 ),
     *                 @OA\Property(
     *                     property="role_id",
     *                     type="integer",
     *                     format="int32",
     *                     description="User's role ID"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="User's email address"
     *                 ),
     *                 @OA\Property(
     *                     property="date_of_birth",
     *                     type="string",
     *                     description="User's date of birth"
     *                 ),
     *                 @OA\Property(
     *                     property="photo",
     *                     type="string",
     *                     description="User's photo URL"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Timestamp when the user was created"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Timestamp when the user was last updated"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found"
     *     )
     * )
     */
    public function adminGetUserByPhone(Request $request)
    {
        //
    }
  
    /**
     * @OA\Get(
     *     path="/api/admin/getRoles",
     *     summary="Get all roles (Admin)",
     *     tags={"Users"},
     *     @OA\Response(
     *         response="200",
     *         description="List of roles",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         format="int64",
     *                         description="Role ID"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         description="Role name"
     *                     ),
     *                     @OA\Property(
     *                         property="created_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the role was created"
     *                     ),
     *                     @OA\Property(
     *                         property="updated_at",
     *                         type="string",
     *                         format="date-time",
     *                         description="Timestamp when the role was last updated"
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
    public function getRoles() 
    {
      //
    }

    /**
     * @OA\Post(
     *     path="/api/admin/getUserBookings",
     *     summary="Get users bookings (Admin)",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="phone",
     *                 type="integer",
     *                 description="Phone number"
     *             )
     *         )
     *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Successful response",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="bookings",
 *                 type="object",
 *                 additionalProperties=@OA\Property(
 *                     type="array",
 *                     @OA\Items(
 *                         @OA\Property(
 *                             property="id",
 *                             type="integer",
 *                             description="Unique identifier for the booking"
 *                         ),
 *                         @OA\Property(
 *                             property="user_id",
 *                             type="integer",
 *                             description="User id"
 *                         ),
 *                         @OA\Property(
 *                             property="object_id",
 *                             type="integer",
 *                             description="Object id"
 *                         ),
 *                         @OA\Property(
 *                             property="booked_from",
 *                             type="string",
 *                             format="date-time",
 *                             description="Booked from"
 *                         ),
 *                         @OA\Property(
 *                             property="booked_to",
 *                             type="string",
 *                             format="date-time",
 *                             description="Booked to"
 *                         ),
 *                         @OA\Property(
 *                             property="payment_status",
 *                             type="boolean",
 *                             description="Payment status"
 *                         ),
     *                         @OA\Property(
     *                             property="canceled",
     *                             type="boolean",
     *                             description="Is booking canceled"
     *                         ),
     *                         @OA\Property(
     *                             property="description",
     *                             type="string",
     *                             description="Description"
     *                         ),
     *                         @OA\Property(
     *                             property="price",
     *                             type="string",
     *                             description="Price"
     *                         ),
     *                         @OA\Property(
     *                             property="created_at",
     *                             type="date",
     *                             description="Created order at"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="User not found"
     *     )
     * )
     */
    public function adminGetUserBookings() 
    {
      //
    }
}
