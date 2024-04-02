<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Automatically change the objects status of expired reserved bookings.
     *
     * @return void
     */
    public static function updateExpiredReservedNotPaidBookingObjectStatus()
    {
        $expiredBookingObjectsIds = Booking::where('reserved_to', '<', Carbon::now())
            ->where('payment_status', 0)
            ->pluck('object_id');

        BookingObject::whereIn('id', $expiredBookingObjectsIds)
            ->update(['status' => ObjectStatus::FREE->value]);
    }

    /**
     * Automatically change the objects status of expired booked.
     *
     * @return void
     */
    public static function updateExpiresBookedBookingObjectStatus()
    {
        $expiredBookingObjects = Booking::where('booked_to', '<', Carbon::now())
            ->pluck('object_id');

        BookingObject::whereIn('id', $expiredBookingObjects)
            ->update(['status' => ObjectStatus::FREE->value]);
    }

    public function reserveObject (Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'object_id' => 'required|integer',
        ]);

        $user = auth()->user();

        if (!$user->phone_verified_at) {
            return response()->json(['message' => 'You need to be verified'], 403);
        }

        if (!BookingObject::where('id', $request->object_id)->first()) {
            return response()->json(['message' => 'Object not found'], 404);
        }

        $newBooking = new Booking ([
            'user_id' => $request->user_id,
            'object_id' => $request->object_id,
            'reserved_from' => Carbon::now(),
            'reserved_to' => Carbon::now()->addMinutes(2), // 2 min for test, replace to 15 in prod
            'payment_status' => 0,
        ]);

        BookingObject::where('id', $request->object_id)
            ->update(['status' => ObjectStatus::RESERVED->value]);

        $newBooking->save();
        
        return response()->json(['message' => 'Object has been reserved'], 200);
    }

    public function bookObject (Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'object_id' => 'required|integer',
            'booked_from' => 'required|date',
            'booked_to' => 'required|date'
        ]);

        Booking::where('user_id', $request->user_id)
            ->where('object_id', $request->object_id)
            ->where('reserved_to', '>', Carbon::now())
            ->update([
                'booked_from' => $request->booked_from,
                'booked_to' => $request->booked_to,
                'payment_status' => 1,
            ]);
        
        BookingObject::where('id', $request->object_id)
            ->update(['status' => ObjectStatus::BOOKED->value]);

        return response()->json(['message' => 'Object has been booked'], 200);
    }
}
