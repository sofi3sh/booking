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
     *                     property="childrens_price",
     *                     type="number",
     *                     format="float",
     *                     description="Price of the booking object for children"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_weekend_price",
     *                     type="number",
     *                     format="float",
     *                     description="Weekend price of the booking object for children"
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
     *                 ),
     *                 @OA\Property(
     *                     property="lang",
     *                     type="string",
     *                     description="Specify language",
     *                     format="lang"
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
     *     path="/api/onec/objects/updateObject/{id}",
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
     *                 property="childrens_price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object for children"
     *             ),
     *             @OA\Property(
     *                 property="childrens_weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object for children"
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
     *                 description="Discount start date of the booking object",
     *                 example="2024-04-08"
     *             ),
     *             @OA\Property(
     *                 property="discount_end_date",
     *                 type="string",
     *                 format="date-time",
     *                 description="Discount end date of the booking object",
     *                 example="2024-04-08"
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
     *                 property="childrens_price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object for children"
     *             ),
     *             @OA\Property(
     *                 property="childrens_weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object for children"
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
     *                 property="childrens_price",
     *                 type="number",
     *                 format="float",
     *                 description="Price of the booking object for children",
     *                 example=100.00
     *             ),
     *             @OA\Property(
     *                 property="childrens_weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Weekend price of the booking object for children",
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
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Booking object ID"),
     *                 @OA\Property(property="name_ua", type="string", description="Booking object name in Ukrainian"),
     *                 @OA\Property(property="name_en", type="string", description="Booking object name in English"),
     *                 @OA\Property(property="price", type="number", format="float", description="Booking object price"),
     *                 @OA\Property(property="weekend_price", type="number", format="float", description="Booking object weekend price"),
     *                 @OA\Property(property="childrens_price", type="number", format="float", description="Booking object price for children"),
     *                 @OA\Property(property="childrens_weekend_price", type="number", format="float", description="Booking object weekend price for children"),
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

    /**
     * @OA\Get(
     *     path="/api/onec/additionalObjects/getAdditionalObjects",
     *     summary="Get all additional objects",
     *     description="Get all additional objects",
     *     tags={"1C"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", description="Additional object ID"),
     *                 @OA\Property(property="name", type="string", description="Additional object name"),
     *                 @OA\Property(property="price", type="number", format="float", description="Additional object price"),
     *                 @OA\Property(property="weekend_price", type="number", format="float", description="Additional object weekend price"),
     *                 @OA\Property(property="childrens_price", type="number", format="float", description="Additional object price for children"),
     *                 @OA\Property(property="childrens_weekend_price", type="number", format="float", description="Additional object weekend price for children"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message",
     *                 example="Not found"
     *             )
     *         )
     *     )
     * )
     */
    public function getAdditionalObjects (Request $request) 
    {
        //
    }


    /**
     * @OA\Post(
     *     path="/api/onec/additionalObjects/updateAdditionalObjectById/{id}",
     *     summary="Update additional object by ID",
     *     description="Update additional object by ID",
     *     tags={"1C"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Additional object ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="price", type="number", format="float", description="Additional object price"),
     *             @OA\Property(property="weekend_price", type="number", format="float", description="Additional object weekend price"),
     *             @OA\Property(property="childrens_price", type="number", format="float", description="Additional object price for children"),
     *             @OA\Property(property="childrens_weekend_price", type="number", format="float", description="Additional object weekend price for children")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 description="Additional object ID",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="name_ua",
     *                 type="string",
     *                 description="Additional object name",
     *                 example="Additional object name"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 format="float",
     *                 description="Additional object price",
     *                 example=100.0
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Additional object weekend price",
     *                 example=100.0
     *             ),
     *             @OA\Property(
     *                 property="childrens_price",
     *                 type="number",
     *                 format="float",
     *                 description="Additional object price for children",
     *                 example=100.0
     *             ),
     *             @OA\Property(
     *                 property="childrens_weekend_price",
     *                 type="number",
     *                 format="float",
     *                 description="Additional object weekend price for children",
     *                 example=100.0
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message",
     *                 example="Not found"
     *             )
     *         )
     *     )
     * )
     */
    public function updateAdditionalObjectById (Request $request) 
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/onec/booking/getLastOrdersByDays",
     *     summary="Get last orders by days",
     *     tags={"1C"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="days",
     *                 type="integer",
     *                 description="Number of days",
     *                 example=7
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
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Order ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     description="User ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="object_id",
     *                     type="integer",
     *                     description="Object ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_from",
     *                     type="string",
     *                     description="Reserved from",
     *                     example="2024-06-24 15:09:43"
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_to",
     *                     type="string",
     *                     description="Reserved to",
     *                     example="2024-06-24 15:09:43"
     *                 ),
     *                 @OA\Property(
     *                     property="booked_from",
     *                     type="string",
     *                     description="Booked from",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="booked_to",
     *                     type="string",
     *                     description="Booked to",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="payment_status",
     *                     type="number",
     *                     description="Payment status",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="canceled",
     *                     type="number",
     *                     description="Canceled",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="order_id",
     *                     type="string",
     *                     description="Order ID",
     *                     example="123456789"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description",
     *                     example="Description"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     description="Price",
     *                     example=100.0
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     description="Created at",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     description="Updated at",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="is_child",
     *                     type="number",
     *                     description="Is child",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="is_admin",
     *                     type="number",
     *                     description="Is admin",
     *                     example=0
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getLastOrdersByDays (Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/onec/booking/getLastTransactionsByDays",
     *     summary="Get last transactions by days",
     *     tags={"1C"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="days",
     *                 type="integer",
     *                 description="Number of days",
     *                 example=7
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
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Order ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="order_id",
     *                     type="string",
     *                     description="Order ID",
     *                     example="123456789"
     *                 ),
     *                 @OA\Property(
     *                     property="amount",
     *                     type="number",
     *                     description="Amount",
     *                     example=100.0
     *                 ),
     *                 @OA\Property(
     *                     property="fee",
     *                     type="number",
     *                     description="Fee",
     *                     example=0.0
     *                 ),
     *                 @OA\Property(
     *                     property="issuer_bank_name",
     *                     type="string",
     *                     description="Issuer bank name",
     *                     example="Issuer bank name"
     *                 ),
     *                 @OA\Property(
     *                     property="card",
     *                     type="string",
     *                     description="Card",
     *                     example="53****8970"
     *                 ),
     *                 @OA\Property(
     *                     property="transaction_status",
     *                     type="number",
     *                     description="Transaction status",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     description="Created at",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     description="Updated at",
     *                     example="2020-01-01 00:00:00"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getLastTransactionsByDays (Request $request)
    {
        //
    }


    /**
     * @OA\Post(
     *     path="/api/onec/booking/getBookingsByOrderId",
     *     summary="Get bookings by order id",
     *     tags={"1C"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="order_id",
     *                 type="string",
     *                 description="Order ID",
     *                 example="123456789"
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
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Order ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     description="User ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="object_id",
     *                     type="integer",
     *                     description="Object ID",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_from",
     *                     type="string",
     *                     description="Reserved from", 
     *                     example="2020-01-01 00:00:00"     
     *                 ),
     *                 @OA\Property(
     *                     property="reserved_to",
     *                     type="string",
     *                     description="Reserved to", 
     *                     example="2020-01-01 00:00:00"     
     *                 ),
     *                 @OA\Property(
     *                     property="booked_from",
     *                     type="string",
     *                     description="Booked from", 
     *                     example="2020-01-01 00:00:00"     
     *                 ),
     *                 @OA\Property(
     *                     property="booked_to",
     *                     type="string",
     *                     description="Booked to", 
     *                     example="2020-01-01 00:00:00"     
     *                 ),
     *                 @OA\Property(
     *                     property="payment_status",
     *                     type="integer",
     *                     description="Payment status",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="canceled",
     *                     type="integer",
     *                     description="Canceled",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="order_id",
     *                     type="string",
     *                     description="Order ID",
     *                     example="123456789"
     *                 ),
     *                 @OA\Property(
     *                     property="description",  
     *                     type="string",
     *                     description="Description",
     *                     example="Description"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     description="Price",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     description="Created at",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     description="Updated at",
     *                     example="2020-01-01 00:00:00"
     *                 ),
     *                 @OA\Property(
     *                     property="is_child",
     *                     type="integer",
     *                     description="Is child",
     *                     example=0
     *                 ),
     *                 @OA\Property(
     *                     property="is_admin",
     *                     type="integer",
     *                     description="Is admin",
     *                     example=0
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No bookings found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Error message",
     *                 example="No bookings found"
     *             )
     *         )
     *     )
     * )
     */
    public function getBookingsByOrderId (Request $request)
    {
        //
    }
}
