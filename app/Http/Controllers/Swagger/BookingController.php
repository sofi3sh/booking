<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Bookings",
 *     description="API for managing bookings"
 * )
 */
class BookingController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/booking/reserveObject",
     *     summary="Reserve booking object for future booking",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="object_id",
     *                 type="integer",
     *                 description="ID of the object we want to reserve"
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
     *         description="Object has been reserved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Object has been reserved"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="You need to be verified",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="You need to be verified"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Object not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Object not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Object is blocked to booking",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Object is blocked to booking"
     *             )
     *         )
     *     ),

     * )
     */
    public function reserveObject ()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/booking/calculateBookingPrice",
     *     summary="Reserve booking object for future booking",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="object_id",
     *                 type="integer",
     *                 description="ID of the object we want to book"
     *             ),
     *             @OA\Property(
     *                 property="booked_from",
     *                 type="string",
     *                 format="date",
     *                 description="Booking start date"
     *             ),
     *             @OA\Property(
     *                 property="booked_to",
     *                 type="string",
     *                 format="date",
     *                 description="booking end date"
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
     *         description="Successful price calculation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="price",
     *                 type="decimal",
     *                 example="999.99"
     *             )
     *         )
     *     )
     * )
     */
    public function calculatePriceForBooking ()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/booking/cancelOrder",
     *     summary="Cancel all bookings in order",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="order_id",
     *                 type="string",
     *                 description="Order ID"
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
     *         description="Order has been canceled succesful",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Order has been canceled"
     *             )
     *         )
     *     )
     * )
     */
    public function cancelBooking ()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/objects/getOrder",
     *     summary="Get bookings by order ID",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="order_id",
     *                 type="string",
     *                 description="Order ID"
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
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bookings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="Unique identifier for the booking"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         description="User id"
     *                     ),
     *                     @OA\Property(
     *                         property="object_id",
     *                         type="integer",
     *                         description="Object id"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_from",
     *                         type="string",
     *                         description="Reserved from"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_to",
     *                         type="string",
     *                         description="Reserved to"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_from",
     *                         type="string",
     *                         description="Booked from"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_to",
     *                         type="string",
     *                         description="Booked to"
     *                     ),
     *                     @OA\Property(
     *                         property="payment_status",
     *                         type="boolean",
     *                         description="Payment status"
     *                     ),
     *                     @OA\Property(
     *                         property="canceled",
     *                         type="boolean",
     *                         description="Is the reservation cancelled"
     *                     ),
     *                     @OA\Property(
     *                         property="order_id",
     *                         type="string",
     *                         description="Order ID"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Description"
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="total_price",
     *                 type="number",
     *                 format="float",
     *                 description="Total price of the order"
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
     *     
     * )
     */
    public function getOdred ()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/booking/admin/bookObjects",
     *     summary="Make a booking using the permission of the administrator. It is possible to book without payment on the website",
     *     tags={"Bookings"},
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(
     *             property="object_id",
     *             type="integer",
     *             description="Object ID"
     *         ),
     *         @OA\Property(
     *             property="booked_from",
     *             type="string",
     *             format="date",
     *             description="Booked from date"
     *         ),
     *         @OA\Property(
     *             property="booked_to",
     *             type="string",
     *             format="date",
     *             description="Booked to date"
     *         ),
     *         @OA\Property(
     *             property="user_id",
     *             type="integer",
     *             description="User ID"
     *         ),
     *         @OA\Property(
     *             property="payment_status",
     *             type="boolean",
     *             description="Payment status (0 - if not paid, 1 - if paid)"
     *         ),
     *         @OA\Property(
     *             property="description",
     *             type="string",
     *             nullable=true,
     *             description="Description"
     *         ),
     *         @OA\Property(
     *             property="lang",
     *             type="string",
     *             description="Specify language",
     *             format="lang"
     *         )
     *     )
     * ),
     *     @OA\Response(
     *         response="200",
     *         description="Objects have been booked successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Objects have been booked successfully"
     *             ),
     *             @OA\Property(
     *                 property="bookings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         description="Unique identifier for the booking"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="integer",
     *                         description="User id"
     *                     ),
     *                     @OA\Property(
     *                         property="object_id",
     *                         type="integer",
     *                         description="Object id"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_from",
     *                         type="string",
     *                         description="Reserved from"
     *                     ),
     *                     @OA\Property(
     *                         property="reserved_to",
     *                         type="string",
     *                         description="Reserved to"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_from",
     *                         type="string",
     *                         description="Booked from"
     *                     ),
     *                     @OA\Property(
     *                         property="booked_to",
     *                         type="string",
     *                         description="Booked to"
     *                     ),
     *                     @OA\Property(
     *                         property="payment_status",
     *                         type="boolean",
     *                         description="Payment status"
     *                     ),
     *                     @OA\Property(
     *                         property="canceled",
     *                         type="boolean",
     *                         description="Is the reservation cancelled"
     *                     ),
     *                     @OA\Property(
     *                         property="order_id",
     *                         type="string",
     *                         description="Order ID"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         description="Description"
     *                     )
     *                 )
     *             ),
     *         )
     *     )
     * )
     */
    public function adminbookObjects ()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/objects/{id}/getBookingsByObjectId",
     *     summary="Get bookings by object id",
     *     tags={"Bookings"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Object id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Unique identifier for the booking"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     description="User id"
     *                 ),
     *                 @OA\Property(
     *                     property="object_id",
     *                     type="integer",
     *                     description="Object id"
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_from",
     *                     type="string",
     *                     description="Reserved from"
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_to",
     *                     type="string",
     *                     description="Reserved to"
     *                 ),
     *                 @OA\Property(
     *                     property="booked_from",
     *                     type="string",
     *                     description="Booked from"
     *                 ),
     *                 @OA\Property(
     *                     property="booked_to",
     *                     type="string",
     *                     description="Booked to"
     *                 ),
     *                 @OA\Property(
     *                     property="payment_status",
     *                     type="boolean",
     *                     description="Payment status"
     *                 ),
     *                 @OA\Property(
     *                     property="canceled",
     *                     type="boolean",
     *                     description="Is the reservation cancelled"
     *                 ),
     *                 @OA\Property(
     *                     property="order_id",
     *                     type="string",
     *                     description="Order ID"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description"
     *                 )
     *             )
     *         ),
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
     *     
     * )
     */
    public function getBookingsByObjectId ()
    {
        //
    }
}
