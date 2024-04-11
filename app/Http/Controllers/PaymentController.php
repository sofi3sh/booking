<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BookingController;
use App\Services\BookingService;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        // Логіка обробки платежу тут

        return response()->json(['message' => 'Payment processed successfully'], 200);
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
        ]);

        $bookings = $this->bookingService->bookExistingReserve($request, auth()->user());

        return response()->json(['message' => 'Objects have been booked successfully', 'bookings' => $bookings], 200);
    }
}
