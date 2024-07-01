<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Models\Transaction;
use App\Enums\ObjectStatus;
use Illuminate\Http\Request;
use App\Services\BookingService;

class PaymentController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function preparePaymentData(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.count' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ]);


        $currentDate = Carbon::now()->timestamp;

        // $merchantAccount = env('MERCHANT_ACCOUNT');
        // $merchantDomainName = env('MERCHANT_DOMAIN_NAME');

        $merchantAccount = 'poolandbeach_zp_ua';
        $merchantDomainName = 'poolandbeach.zp.ua';
        $orderReference = strtoupper(uniqid());
        $orderDate = $currentDate;
        $amount = $request->amount;
        $currency = 'UAH';
        $products = $request->products;

        $data = $merchantAccount . ';' . $merchantDomainName . ';' . $orderReference . ';' . $orderDate . ';' . $amount . ';' . $currency;

        $productNames = [];
        $productCounts = [];
        $productPrices = [];

        foreach ($products as $product) {
            $productNames[] = $product['name'];
            $productCounts[] = $product['count'];
            $productPrices[] = $product['price'];
        }

        $data .= ';' . implode(';', $productNames);
        $data .= ';' . implode(';', $productCounts);
        $data .= ';' . implode(';', $productPrices);

        //
        
        // $key = env('MERCHANT_kEY');

        $key = 'c632cb72916700a3d83ac83794925ab09642bbe7';

        $merchantSignature = hash_hmac('md5', $data, $key);

        return response()->json([
            'merchantSignature' => $merchantSignature,
            'merchantAccount' => $merchantAccount,
            'merchantDomainName' => $merchantDomainName,
            'orderReference' => $orderReference,
            'orderDate' => $orderDate,
            'currency' => $currency,
        ], 200);
    }

    public function createOrder (Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'amount' => 'required|numeric',
            'fee' => 'required|numeric',
            'issuer_bank_name' => 'required|string',
            'card' => 'required|string',
            'transaction_status' => 'required|boolean',
            'objects' => 'required|array|min:1',
            'objects.*.object_id' => 'required|integer',
            'objects.*.booked_from' => 'required|date',
            'objects.*.booked_to' => 'required|date|after_or_equal:objects.*.booked_from',
            'objects.*.user_id' => 'required|integer',
            'objects.*.payment_status' => 'required|boolean',
            'objects.*.description' => 'nullable|string',
            'objects.*.is_clild' => 'nullable|boolean',
            'objects.*.is_additional' => 'required|boolean',
            'objects.*.lang' => 'sometimes|required|string'
        ]);

        $transaction = Transaction::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'fee' => $request->fee,
            'issuer_bank_name' => $request->issuer_bank_name,
            'card' => $request->card,
            'transaction_status' => $request->transaction_status,
        ]);

        $bookings = $this->bookingService->bookExistingReserve($request->objects, auth()->user(), $request->order_id);

        return response()->json(['bookings' => $bookings, 'transaction' => $transaction], 200);
    }
}
