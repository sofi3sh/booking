<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/**
 * @OA\Tag(
 *     name="ObjectDetails",
 *     description="API for managing objects"
 * ),
 * @OA\Schema(
 *     schema="ObjectDetails",
 *     required={"booking_object_id", "title_ua", "title_en", "description_ua", "description_en"},
 *     @OA\Property(
 *         property="booking_object_id",
 *         type="integer",
 *         description="ID of the booking object"
 *     ),
 *     @OA\Property(
 *         property="title_ua",
 *         type="string",
 *         description="Title of the object in Ukrainian"
 *     ),
 *     @OA\Property(
 *         property="title_en",
 *         type="string",
 *         description="Title of the object in English"
 *     ),
 *     @OA\Property(
 *         property="description_ua",
 *         type="string",
 *         description="Description of the object in Ukrainian"
 *     ),
 *     @OA\Property(
 *         property="description_en",
 *         type="string",
 *         description="Description of the object in English"
 *     ),
 *     @OA\Property(
 *         property="img",
 *         type="string",
 *         description="URL of the image of the object"
 *     )
 * ),
 * @OA\Schema(
 *     schema="ObjectDetailsForUsers",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the booking object details"
 *     ),
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         description="Title of the object"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the object"
 *     ),
 *     @OA\Property(
 *         property="img",
 *         type="string",
 *         description="URL of the image of the object"
 *     )
 * )
 */
class ObjectDetailsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/admin/objectDetails",
     *      tags={"ObjectDetails"},
     *      summary="Get all object details",
     *      description="Returns all object details",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ObjectDetails")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Permission denied",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Permission denied"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="No objects details found"
     *              )
     *          ),
     *      )
     *   )
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/objects/{objectId}/details/showAllByObjectId",
     *      tags={"ObjectDetails"},
     *      summary="Get all object details by object ID",
     *      description="Returns all object details by object ID",
     *      @OA\RequestBody (
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="lang",
     *                  type="string",
     *                  description="Language",
     *                  example="ua"
     *              )
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="objectId",
     *          in="path",
     *          required=true,
     *          description="ID of the booking object",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ObjectDetailsForUsers")
     *          )
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="No objects details found"
     *              )
     *          ),
     *      )
     *   )
     */
    public function showAllByObjectId($objectId)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/admin/objectDetails/{id}",
     *      tags={"ObjectDetails"},
     *      summary="Get object details by ID",
     *      description="Returns object details by ID",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the object details",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ObjectDetails")
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Permission denied",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Permission denied"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Object detail not found"
     *              )
     *          ),
     *      )
     *   )
     */
    public function show($id)
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/admin/objectDetails",
     *      tags={"ObjectDetails"},
     *      summary="Create object details",
     *      description="Create object details",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ObjectDetails")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ObjectDetails")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Permission denied",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Permission denied"
     *              )
     *          )
     *      )
     *   )
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @OA\Put(
     *      path="/api/admin/objectDetails/{id}",
     *      tags={"ObjectDetails"},
     *      summary="Update object details",
     *      description="Update object details",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the object details",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ObjectDetails")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ObjectDetails")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Permission denied",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Permission denied"
     *              )
     *          )
     *      )
     *   )
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *      path="/api/admin/objectDetails/{id}",
     *      tags={"ObjectDetails"},
     *      summary="Delete object details",
     *      description="Delete object details",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID of the object details",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Object detail deleted successfully"
     *              )
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Permission denied",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Permission denied"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  description="Message",
     *                  example="Object detail not found"
     *              )
     *          ),
     *      )
     *   )
     */
    public function destroy($id)
    {
        //
    }
}
