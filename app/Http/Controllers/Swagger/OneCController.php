<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="1C",
 *     description="API for 1C"
 * )
 */
class OneCController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/onec/objects",
     *     summary="Get all booking objects",
     *     tags={"1C"},
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Unique identifier for the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Name of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     format="float",
     *                     description="Price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="number",
     *                     format="float",
     *                     description="Weekend price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount",
     *                     type="number",
     *                     format="float",
     *                     description="Discount of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_start_date",
     *                     type="string",
     *                     format="date-time",
     *                     description="Discount start date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_end_date",
     *                     type="string",
     *                     format="date-time",
     *                     description="Discount end date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     description="Status of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     description="Type of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="max_persons",
     *                     type="integer",
     *                     description="Maximum number of persons for the booking object"
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="No booking objects found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/onec/objects/object/{id}",
     *     summary="Update booking object",
     *     tags={"1C"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the booking object to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount",
     *                 type="number",
     *                 format="float",
     *                 description="Discount of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_start_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount start date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_end_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount end date of the booking object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 description="Unique identifier for the booking object"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Name of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount",
     *                 type="number",
     *                 format="float",
     *                 description="Discount of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_start_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount start date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_end_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount end date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 description="Status of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 description="Type of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="max_persons",
     *                 type="integer",
     *                 description="Maximum number of persons for the booking object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="No booking object found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message"
     *             )
     *         )
     *     )
     * )
     */     
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/onec/objects/updateAllByType",
     *     summary="Update all booking objects by type",
     *     tags={"1C"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type"},
     *             type="object",
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 description="Type of the booking object",
     *                 example="sunbed"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object",
     *                 example=100.00
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object",
     *                 example=120.00
     *             ),
     *             @OA\Property(
     *                 property="discount",
     *                 type="number",
     *                 format="float",
     *                 description="Discount of the booking object",
     *                 example=10.00
     *             ),
     *             @OA\Property(
     *                 property="discount_start_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount start date of the booking object",
     *                 example="2024-04-08"
     *             ),
     *             @OA\Property(
     *                 property="discount_end_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount end date of the booking object",
     *                 example="2024-05-08"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Booking object ID"),
     *                 @OA\Property(property="name", type="string", description="Booking object name"),
     *                 @OA\Property(property="price", type="number", format="float", description="Booking object price"),
     *                 @OA\Property(property="weekend_price", type="number", format="float", description="Booking object weekend price"),
     *                 @OA\Property(property="discount", type="number", format="float", description="Booking object discount"),
     *                 @OA\Property(property="discount_start_date", type="string", format="date-time", description="Booking object discount start date"),
     *                 @OA\Property(property="discount_end_date", type="string", format="date-time", description="Booking object discount end date"),
     *                 @OA\Property(property="zone", type="string", description="Booking object zone"),
     *                 @OA\Property(property="status", type="string", description="Booking object status"),
     *                 @OA\Property(property="type", type="string", description="Booking object type"),
     *                 @OA\Property(property="max_persons", type="integer", description="Maximum persons allowed in the booking object")
     *             )
     *         )
     *     )
     * )
     */
    public function updateAllByType(Request $request)
    {
        //
    }
}
