<?php

namespace App\Http\Controllers\Swagger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Payment",
 *     description="API for payment"
 * )
 */
class PaymentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/preparePaymentData",
     *     summary="Prepare payment data",
     *     description="Prepare payment data",
     *     operationId="preparePaymentData",
     *     tags={"Payment"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="amount",
     *                     type="number",
     *                     description="Amount of payment"
     *                 ),
     *                 @OA\Property(
     *                     property="products",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(
     *                             property="name",
     *                             type="string",
     *                             description="Name of product"
     *                         ),
     *                         @OA\Property(
     *                             property="count",
     *                             type="number",
     *                             description="Count of product"
     *                         ),
     *                         @OA\Property(
     *                             property="price",
     *                             type="number",
     *                             description="Price of product"
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="merchantSignature",
     *                 type="string",
     *                 description="Merchant signature"
     *             ),
     *             @OA\Property(
     *                 property="merchantAccount",
     *                 type="string",
     *                 description="Merchant account"
     *             ),
     *             @OA\Property(
     *                 property="merchantDomainName",
     *                 type="string",
     *                 description="Merchant domain name"
     *             ),
     *             @OA\Property(
     *                 property="orderReference",
     *                 type="string",
     *                 description="Order reference"
     *             ),
     *             @OA\Property(
     *                 property="orderDate",
     *                 type="number",
     *                 description="Order date"
     *             ),
     *             @OA\Property(
     *                 property="currency",
     *                 type="string",
     *                 description="Currency"
     *             )
     *         )
     *     )
     * )
     */
    public function preparePaymentData(Request $request)
    {
        //
    }
}
