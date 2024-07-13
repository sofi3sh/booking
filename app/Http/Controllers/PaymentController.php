<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Models\Transaction;
use App\Enums\ObjectStatus;
use Illuminate\Http\Request;
use App\Services\BookingService;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function preparePaymentData(Request $request, $orderReference = null)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'products' => 'required|array',
            'products.*.name' => 'required|string',
            'products.*.count' => 'required|numeric',
            'products.*.price' => 'required|numeric',
            'objects' => 'required|array|min:1',
            'objects.*.object_id' => 'required|integer',
            'objects.*.booked_from' => 'required|date',
            'objects.*.booked_to' => 'required|date|after_or_equal:objects.*.booked_from',
            'objects.*.user_id' => 'required|integer',
            'objects.*.payment_status' => 'required|boolean',
            'objects.*.description' => 'nullable|string',
            'objects.*.is_child' => 'nullable|boolean',
            'objects.*.is_additional' => 'required|boolean',
            'objects.*.lang' => 'sometimes|required|string'
        ]);


        $currentDate = Carbon::now()->timestamp;

        // $merchantAccount = env('MERCHANT_ACCOUNT');
        // $merchantDomainName = env('MERCHANT_DOMAIN_NAME');

        $merchantAccount = 'poolandbeach_zp_ua';
        $merchantDomainName = 'poolandbeach.zp.ua';
        $orderReference = $orderReference ?? strtoupper(uniqid());
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

        $baseUrl = env('APP_URL');



        $isAdmin = false;

        $this->bookingService->bookExistingReserve($request->objects, auth()->user(), $orderReference, $isAdmin);

        return response()->json([
            'merchantSignature' => $merchantSignature,
            'merchantAccount' => $merchantAccount,
            'merchantDomainName' => $merchantDomainName,
            'orderReference' => $orderReference,
            'orderDate' => $orderDate,
            'currency' => $currency,
            'serviceUrl' => '' . $baseUrl . '/api/payment/proccessPayment',
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
            'transaction_status' => 'required|string',
            'objects' => 'required|array|min:1',
            'objects.*.object_id' => 'required|integer',
            'objects.*.booked_from' => 'required|date',
            'objects.*.booked_to' => 'required|date|after_or_equal:objects.*.booked_from',
            'objects.*.user_id' => 'required|integer',
            'objects.*.payment_status' => 'required|boolean',
            'objects.*.description' => 'nullable|string',
            'objects.*.is_child' => 'nullable|boolean',
            'objects.*.is_additional' => 'required|boolean',
            'objects.*.lang' => 'sometimes|required|string'
        ]);

        Log::info('Це інформаційне повідомлення.');
        Log::info(auth()->user()->phone);

        $transaction = Transaction::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'fee' => $request->fee,
            'issuer_bank_name' => $request->issuer_bank_name,
            'card' => $request->card,
            'transaction_status' => $request->transaction_status,
            'phone' => auth()->user()->phone
        ]);

        $isAdmin = false;

        $bookings = $this->bookingService->bookExistingReserve($request->objects, auth()->user(), $request->order_id, $isAdmin);

        return response()->json(['bookings' => $bookings, 'transaction' => $transaction], 200);
    }

    public function proccessPayment (Request $request) {
        Log::info($request->all());
        Log::info('-------------------------------------');
        $value = array_key_first($request->all());
        $transactionData = json_decode($value, true);
        if(!$transactionData) {
            $json = file_get_contents('php://input');
            $transactionData = json_decode($json, true);
        }
        if(!$transactionData) {
            $data = preg_replace('/"fee":\s?[\d.]+,?/', '', $value);
            $transactionData = json_decode($data, true);
        }
        if (!$transactionData) {
            $json = file_get_contents('php://input');
            $data = preg_replace('/"fee":\s?[\d.]+,?/', '', $json);
            $transactionData = json_decode($data, true);
        }
        Log::info($value);
        Log::info('-------------------------------------');

        Log::info($transactionData);
        Log::info('-------------------------------------');




        $orderId = $transactionData['orderReference'];
        $transactionStatus = $transactionData['transactionStatus'];
        if($transactionStatus === "Pending" || $transactionStatus === "InProcessing") return;
        if(!isset($transactionData['issuerBankName'])) return;
         $transaction = Transaction::where('order_id', $orderId)->first();
        if($transaction) {
            $transaction->transaction_status = $transactionStatus;
            $transaction->save();
        } else {
            Transaction::create([
                'order_id' => $orderId,
                'amount' => $transactionData['amount'],
                'fee' => $transactionData['fee'] ?? 0,
                'issuer_bank_name' => $transactionData['issuerBankName'],
                'card' => $transactionData['cardPan'],
                'transaction_status' => $transactionStatus,
                'phone' => $transactionData['phone']
            ]);
        }



        if ($transactionStatus == 'Expired' || $transactionStatus == 'Declined') {
            Booking::where('order_id', $orderId)->update([
                'canceled' => 1,
                'payment_status' => 0
            ]);
        } else {
            Booking::where('order_id', $orderId)->update([
                'payment_status' => 1
            ]);
        }

        $bookingsInOrder = Booking::where('order_id', $orderId)->get();
        $status = $transactionStatus == 'Expired' || $transactionStatus == 'Declined' ? ObjectStatus::FREE->value  : ObjectStatus::BOOKED->value;
        foreach ($bookingsInOrder as $booking) {
            $this->bookingService->customUpdateBookingObjectStatus(BookingObject::find($booking->object_id),$status);
        }
    }

    public function checkTransactionStatus(Request $request)
    {
        $transaction = Transaction::where('order_id', $request->order_id)->select('transaction_status')->first();
        return response()->json($transaction);
    }

    public function redirectToCart(Request $request)
    {
        $transactionData = $request->all();
        Log::info($transactionData);
        return redirect()->away('http://localhost:3000/ua/cart?transaction_status='.$transactionData['transactionStatus']);
    }
}
