<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Objects",
 *     description="API for managing objects"
 * )
 */
class BookingObjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/objects",
     *     summary="Get all booking objects",
     *     tags={"Objects"},
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
     *                     property="description",
     *                     type="string",
     *                     description="Description of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     description="Price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="number",
     *                     description="Weekend price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount",
     *                     type="number",
     *                     description="Discount of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_start_date",
     *                     type="string",
     *                     format="date",
     *                     description="Discount start date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_end_date",
     *                     type="string",
     *                     format="date",
     *                     description="Discount end date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="string",
     *                     description="Photos for the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="zone",
     *                     type="string",
     *                     enum={"bungalow", "pool", "cottages"},
     *                     description="Zone of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     enum={"free", "reserved", "booked"},
     *                     description="Status of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     enum={"sunbed", "bed", "bungalow", "second bungalow", "little cottage", "big cottage"},
     *                     description="Type of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="preview_photo",
     *                     type="string",
     *                     description="Preview photo of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="max_persons",
     *                     type="integer",
     *                     description="Max persons of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Creation date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Update date of the booking object"
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Object not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="No booking objects found",
     *                 description="No booking objects found"
     *             )
     *         ),
     *     )
     * )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/admin/objects",
     *     summary="Create a new object",
     *     tags={"Objects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     description="Name of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="integer",
     *                     description="Price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="string",
     *                     description="Photos for the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="preview_photo",
     *                     type="string",
     *                     description="Preview photo of the object"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Object created successfully"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request"
     *     )
     * )
     */
    public function store(Request $request)
    {

    }

    /**
     * @OA\Get(
     *     path="/api/objects/{id}",
     *     summary="Get a booking object by ID",
     *     tags={"Objects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the booking object",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *                 property="description",
     *                 type="string",
     *                 description="Description of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="number",
     *                 description="Price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="number",
     *                 description="Weekend price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount",
     *                 type="number",
     *                 description="Discount of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_start_date",
     *                 type="string",
     *                 format="date",
     *                 description="Discount start date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="discount_end_date",
     *                 type="string",
     *                 format="date",
     *                 description="Discount end date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="photos",
     *                 type="string",
     *                 description="Photos for the booking object"
     *             ),
     *             @OA\Property(
     *                 property="zone",
     *                 type="string",
     *                 enum={"bungalow", "pool", "cottages"},
     *                 description="Zone of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"free", "reserved", "booked"},
     *                 description="Status of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="type",
     *                 type="string",
     *                 enum={"sunbed", "bed", "bungalow", "second bungalow", "little cottage", "big cottage"},
     *                 description="Type of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="preview_photo",
     *                 type="string",
     *                 description="Preview photo of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="max_persons",
     *                 type="integer",
     *                 description="Maximum person of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Creation date of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Update date of the booking object"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Object not found"
     *     )
     * )
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/admin/objects/{id}",
     *     summary="Update a booking object by ID",
     *     tags={"Objects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the booking object",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Name of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="description",
     *                 type="string",
     *                 description="Description of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="integer",
     *                 description="Price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="photos",
     *                 type="string",
     *                 description="Photos for the booking object"
     *             ),
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 enum={"free", "reserved", "booked"},
     *                 description="Status of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="preview_photo",
     *                 type="string",
     *                 format="binary",
     *                 description="Preview photo of the booking object"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Object updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Success message"
     *             ),
     *             @OA\Property(
     *                 property="object",
     *                 type="object",
     *                 description="Updated booking object details"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Object not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/objects/{id}",
     *     summary="Delete a booking object by ID",
     *     tags={"Objects"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the booking object",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Object deleted successfully",
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
     *         response="404",
     *         description="Object not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @OA\Post(
     *     path="/api/objects/getAvailableObjectsByDate",
     *     summary="Get all available objects",
     *     description="Get all available objects",
     *     tags={"Objects"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="date",
     *                 type="string",
     *                 format="date",
     *                 description="Date of the booking"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
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
     *                     property="description",
     *                     type="string",
     *                     description="Description of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number",
     *                     description="Price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="number",
     *                     description="Weekend price of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount",
     *                     type="number",
     *                     description="Discount of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_start_date",
     *                     type="string",
     *                     format="date",
     *                     description="Discount start date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="discount_end_date",
     *                     type="string",
     *                     format="date",
     *                     description="Discount end date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="photos",
     *                     type="string",
     *                     description="Photos for the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="zone",
     *                     type="string",
     *                     enum={"bungalow", "pool", "cottages"},
     *                     description="Zone of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     enum={"free", "reserved", "booked"},
     *                     description="Status of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     enum={"sunbed", "bed", "bungalow", "second bungalow", "little cottage", "big cottage"},
     *                     description="Type of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="preview_photo",
     *                     type="string",
     *                     format="binary",
     *                     description="Preview photo of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="max_persons",
     *                     type="integer",
     *                     description="Max persons of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Creation date of the booking object"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Update date of the booking object"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAvailableObjectsByDate (Request $request)
    {
        //
    }

}
