<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Reviews",
 *     description="API for reviews"
 * )
 */
class ReviewController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/reviews",
     *     summary="Get all reviews",
     *     tags={"Reviews"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Unique identifier for the review"
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
     *                     property="object_type",
     *                     type="string",
     *                     description="Object type"
     *                 ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     description="Text of the review"
     *                 ),
     *                 @OA\Property(
     *                     property="rating",
     *                     type="integer",
     *                     description="Rating of the review from 1 to 5"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Created at"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Updated at"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No reviews found",
     *     )
     * )
     */
    public function index()
    {
      //    
    }

    /**
     * @OA\Post(
     *     path="/api/objects/{id}/reviews",
     *     summary="Create a review",
     *     tags={"Reviews"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="text",
     *                 type="string",
     *                 description="Text of the review"
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
     *             type="object",
     *             @OA\Property(
     *                 property="user_id",
     *                 type="integer",
     *                 description="User id"
     *             ),
     *             @OA\Property(
     *                 property="object_id",
     *                 type="integer",
     *                 description="Object id"
     *             ),
     *             @OA\Property(
     *                 property="object_type",
     *                 type="string",
     *                 description="Object type"
     *             ),
     *             @OA\Property(
     *                 property="text",
     *                 type="string",
     *                 description="Text of the review"
     *             ),
     *             @OA\Property(
     *                 property="rating",
     *                 type="integer",
     *                 description="Rating of the review from 1 to 5"
     *             ),
     *             @OA\Property(
     *                 property="created_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Created at"
     *             ),
     *             @OA\Property(
     *                 property="updated_at",
     *                 type="string",
     *                 format="date-time",
     *                 description="Updated at"
     *             ),
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 description="Unique identifier for the review"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Object not found",
     *     )
     * )
     */
    public function store(Request $request, $id)
    {
        //
    }


    /**
     * @OA\Get(
     *     path="/api/objects/{id}/reviews/showAllByObjectId",
     *     summary="Get all reviews for a specific object",
     *     description="Get all reviews by object id or by type of object(bed or sunbed)",
     *     tags={"Reviews"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the object",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
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
     *                     description="Unique identifier for the review"
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
     *                     property="object_type",
     *                     type="string",
     *                     description="Object type"
     *                 ),
     *                 @OA\Property(
     *                     property="text",
     *                     type="string",
     *                     description="Text of the review"
     *                 ),
     *                 @OA\Property(
     *                     property="rating",
     *                     type="integer",
     *                     description="Rating of the review from 1 to 5"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Created at"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     description="Updated at"
     *                 ),
     *                 @OA\Property(
     *                     property="user_name",
     *                     type="string",
     *                     description="Name of the user who wrote the review"
     *                 ),
     *                 @OA\Property(
     *                     property="user_last_name",
     *                     type="string",
     *                     description="Last name of the user who wrote the review"
     *                 ),
     *                 @OA\Property(
     *                     property="user_photo",
     *                     type="string",
     *                     description="URL to the photo of the user who wrote the review"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Object not found",
     *     )
     * )
     */
    public function showAllByObjectId($id)
    {
        //
    }
}
