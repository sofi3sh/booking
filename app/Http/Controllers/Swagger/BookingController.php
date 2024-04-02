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
