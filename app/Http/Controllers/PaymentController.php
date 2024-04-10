<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function preparePaymentData(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'productName' => 'required|string',
            'productCount' => 'required|string',
            'productPrice' => 'required|string',
        ]);


        $currentDate = date('U');

        $merchantAccount = env('MERCHANT_ACCOUNT');
        $merchantDomainName = env('MERCHANT_DOMAIN_NAME');
        $orderReference = strtoupper(uniqid());
        $orderDate = $currentDate;
        $amount = $request->amount;
        $currency = 'UAH';
        $productName = $request->productName;
        $productCount = $request->productCount;
        $productPrice = $request->productPrice;

        $data = implode(';', [
            $merchantAccount,
            $merchantDomainName,
            $orderReference,
            $orderDate,
            $amount,
            $currency,
            $productName,
            $productCount,
            $productPrice
        ]);
        
        $key = env('MERCHANT_kEY');

        $merchantSignature = hash_hmac('md5', $data, $key);

        return response()->json(['merchantSignature' => $merchantSignature], 200);
    }
        
}
