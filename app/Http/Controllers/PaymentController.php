<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Логіка обробки платежу тут

        return response()->json(['message' => 'Payment processed successfully'], 200);
    }
}
