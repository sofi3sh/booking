<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingObject;

class OneCController extends Controller
{
    public function index()
    {
        $bookingObjects = BookingObject::all();

        if ($bookingObjects->isEmpty()) {
            return response()->json(['message' => 'No booking objects found'], 404);
        }

        $filteredBookingObjects = $bookingObjects->map(function ($bookingObject) {
            return $bookingObject->only(['id', 'name', 'price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'status', 'max_persons']);
        });

        return response()->json($filteredBookingObjects, 200);
    }
}
