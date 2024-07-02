<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="AdditionalObject",
 *     description="API for additional objects"
 * )
 */
class AdditionalObjectController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/additionalObjects/getAdditionalObjects",
     *     summary="Get additional objects",
     *     tags={"AdditionalObject"},
     *     @OA\Response(
     *         response="200",
     *         description="Get additional objects successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="вхід до басейну"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="опис"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     example="200.00"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="string",
     *                     example="150.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_weekend_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="is_available",
     *                     type="string",
     *                     example="yes"
     *                 )
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
     *     )
     * )
     */
    public function getAdditionalObjects ()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/additionalObjects/addAdditionalObject",
     *     summary="Add additional object",
     *     tags={"AdditionalObject"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name_ua",
     *                     type="string",
     *                     example="вхід до басейну"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     type="string",
     *                     example="pool entrance"
     *                 ),
     *                 @OA\Property(
     *                     property="description_ua",
     *                     type="string",
     *                     example="опис"
     *                 ),
     *                 @OA\Property(
     *                     property="description_en",
     *                     type="string",
     *                     example="description"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     example="200.00"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="string",
     *                     example="150.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_weekend_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="is_available",
     *                     type="string",
     *                     example="yes"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Additional object added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Additional object added successfully"
     *             ),
     *             @OA\Property(
     *                 property="object",
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="name_ua",
     *                     type="string",
     *                     example="вхід до басейну"
     *                 ),
     *                 @OA\Property(
     *                     property="name_en",
     *                     type="string",
     *                     example="pool entrance"
     *                 ),
     *                 @OA\Property(
     *                     property="description_ua",
     *                     type="string",
     *                     example="опис"
     *                 ),
     *                 @OA\Property(
     *                     property="description_en",
     *                     type="string",
     *                     example="description"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     example="200.00"
     *                 ),
     *                 @OA\Property(
     *                     property="weekend_price",
     *                     type="string",
     *                     example="150.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="childrens_weekend_price",
     *                     type="string",
     *                     example="100.00"
     *                 ),
     *                 @OA\Property(
     *                     property="is_available",
     *                     type="string",
     *                     example="yes"
     *                 ),
     *                 @OA\Property(
     *                     property="created_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-06-28T12:34:56Z"
     *                 ),
     *                 @OA\Property(
     *                     property="updated_at",
     *                     type="string",
     *                     format="date-time",
     *                     example="2024-06-28T12:34:56Z"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="permission_denied"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="503",
     *         description="Not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthenticated."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Line 102 - /booking/vendor/laravel/framework/src/Illuminate/Auth/Middleware/Authenticate.php"
     *             )
     *         )
     *     )
     * )
     */
    public function addAdditionalObject (Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/additionalObjects/editAdditionalObject",
     *     summary="Edit additional object",
     *     tags={"AdditionalObject"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             ),
     *             @OA\Property(
     *                 property="name_ua",
     *                 type="string",
     *                 example="вхід до басейну"
     *             ),
     *             @OA\Property(
     *                 property="name_en",
     *                 type="string",
     *                 example="pool entrance"
     *             ),
     *             @OA\Property(
     *                 property="description_ua",
     *                 type="string",
     *                 example="опис"
     *             ),
     *             @OA\Property(
     *                 property="description_en",
     *                 type="string",
     *                 example="description"
     *             ),
     *             @OA\Property(
     *                 property="price",
     *                 type="string",
     *                 example="200.00"
     *             ),
     *             @OA\Property(
     *                 property="weekend_price",
     *                 type="string",
     *                 example="150.00"
     *             ),
     *             @OA\Property(
     *                 property="childrens_price",
     *                 type="string",
     *                 example="100.00"
     *             ),
     *             @OA\Property(
     *                 property="childrens_weekend_price",
     *                 type="string",
     *                 example="100.00"
     *             ),
     *             @OA\Property(
     *                 property="is_available",
     *                 type="string",
     *                 example="yes"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Additional object updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Additional object updated successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="permission_denied"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="503",
     *         description="The selected id is invalid.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The selected id is invalid."
     *             ),
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Line 368 - /booking/vendor/laravel/framework/src/Illuminate/Support/helpers.php"
     *             )
     *         )
     *     )
     * )
     */
    public function editAdditionalObject (Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/additionalObjects/deleteAdditionalObject",
     *     summary="Delete additional object",
     *     tags={"AdditionalObject"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="id",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Additional object deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Additional object deleted successfully"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Permission denied",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="permission_denied"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="object not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="object not found"
     *             )
     *         )
     *     )
     * )
     */
    public function deleteAdditionalObject (Request $request)
    {
        //
    }
}
