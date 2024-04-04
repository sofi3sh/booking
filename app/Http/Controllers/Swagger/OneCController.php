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
}
