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
     *     path="/api/payment/preparePaymentData",
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
     *                 ),
     *                 @OA\Property(
     *                     property="lang",
     *                     type="string",
     *                     description="Specify language",
     *                     format="lang"
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
     *             ),
     *             @OA\Property(
     *                 property="serveiceUrl",
     *                 type="string",
     *                 description="Service URL"
     *             )
     *         )
     *     )
     * )
     */
    public function preparePaymentData(Request $request)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/payment/createOrder",
     *     summary="Create an order",
     *     description="Create an order with the given details",
     *     operationId="createOrder",
     *     tags={"Payment"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="order_id", type="integer", description="Order ID"),
     *             @OA\Property(property="amount", type="number", description="Amount"),
     *             @OA\Property(property="fee", type="number", description="Fee"),
     *             @OA\Property(property="issuer_bank_name", type="string", description="Issuer Bank Name"),
     *             @OA\Property(property="card", type="string", description="Card"),
     *             @OA\Property(property="transaction_status", type="boolean", description="Transaction Status"),
     *             @OA\Property(
     *                 property="objects",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="object_id", type="integer", description="Object ID"),
     *                     @OA\Property(property="booked_from", type="string", format="date", description="Booked From"),
     *                     @OA\Property(property="booked_to", type="string", format="date", description="Booked To"),
     *                     @OA\Property(property="user_id", type="integer", description="User ID"),
     *                     @OA\Property(property="payment_status", type="boolean", description="Payment Status"),
     *                     @OA\Property(property="description", type="string", description="Description"),
     *                     @OA\Property(property="is_child", type="boolean", description="Is Child"),
     *                     @OA\Property(property="lang", type="string", description="Language")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bookings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="user_id", type="integer", description="User ID"),
     *                     @OA\Property(property="object_id", type="integer", description="Object ID"),
     *                     @OA\Property(property="reserved_from", type="string", format="date-time", description="Reserved From"),
     *                     @OA\Property(property="reserved_to", type="string", format="date-time", description="Reserved To"),
     *                     @OA\Property(property="booked_from", type="string", format="date-time", description="Booked From"),
     *                     @OA\Property(property="booked_to", type="string", format="date-time", description="Booked To"),
     *                     @OA\Property(property="payment_status", type="boolean", description="Payment Status"),
     *                     @OA\Property(property="description", type="string", description="Description"),
     *                     @OA\Property(property="order_id", type="string", description="Order ID"),
     *                     @OA\Property(property="price", type="number", description="Price"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", description="Updated At"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", description="Created At"),
     *                     @OA\Property(property="id", type="integer", description="Booking ID")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="transaction",
     *                 type="object",
     *                 @OA\Property(property="order_id", type="string", description="Order ID"),
     *                 @OA\Property(property="amount", type="number", description="Amount"),
     *                 @OA\Property(property="fee", type="number", description="Fee"),
     *                 @OA\Property(property="issuer_bank_name", type="string", description="Issuer Bank Name"),
     *                 @OA\Property(property="card", type="string", description="Card"),
     *                 @OA\Property(property="transaction_status", type="boolean", description="Transaction Status"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", description="Updated At"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", description="Created At"),
     *                 @OA\Property(property="id", type="integer", description="Transaction ID")
     *             )
     *         )
     *     )
     * )
     */
    public function createOrder(Request $request)
    {
        //
    }
}
