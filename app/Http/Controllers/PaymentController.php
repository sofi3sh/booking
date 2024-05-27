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

        $merchantAccount = env('MERCHANT_ACCOUNT');
        $merchantDomainName = env('MERCHANT_DOMAIN_NAME');
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
        
        $key = env('MERCHANT_kEY');

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
            'order_id' => 'required|integer',
            'amount' => 'required|decimal',
            'fee' => 'required|decimal',
            'issuer_bank_name' => 'required|string',
            'card' => 'required|string',
            'transaction_status' => 'required|string',
            'is_child' => 'required|boolean'
        ]);

        $transaction = Transaction::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'fee' => $request->fee,
            'issuer_bank_name' => $request->issuer_bank_name,
            'card' => $request->card,
            'transaction_status' => $request->transaction_status,
        ]);
    
        $bookings = $this->bookingService->bookExistingReserve($request->all(), auth()->user());

        return response()->json(['bookings' => $bookings, 'transaction' => $transaction], 200);
    }
}
