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
     *                     description="Preview photo of the booking object"
     *                 )
     *             )
     *         ),
     *     ),
     * )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/objects",
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
     *                 type="integer",
     *                 description="Price of the booking object"
     *             ),
     *             @OA\Property(
     *                 property="photos",
     *                 type="string",
     *                 description="Photos for the booking object"
     *             ),
     *             @OA\Property(
     *                 property="preview_photo",
     *                 type="string",
     *                 description="Preview photo of the booking object"
     *             )
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
     *     path="/api/objects/{id}",
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
     *                 property="preview_photo",
     *                 type="string",
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
}
