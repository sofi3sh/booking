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

    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    private function createObjectReservation ($userId, $objectId)
    {
        return new Booking ([
            'user_id' => $userId,
            'object_id' => $objectId,
            'reserved_from' => Carbon::now(),
            'reserved_to' => Carbon::now()->addMinutes(2), // 2 min for test, replace to 15 in prod
            'payment_status' => 0,
        ]);
    }

    private function createBooking ($userId, $objectId, $dateFrom, $dateTo, $paymentStatus = 0)
    {
        return new Booking ([
            'user_id' => $userId,
            'object_id' => $objectId,
            'booked_from' => $dateFrom,
            'booked_to' => $dateTo,
            'payment_status' => $paymentStatus,
        ]);
    }

    public function reserveObject (Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
        ]);

        $user = auth()->user();

        if (!$user->phone_verified_at) {
            return response()->json(['message' => 'You need to be verified'], 403);
        }

        $bookingObject = BookingObject::where('id', $request->object_id)->first();

        if (!$bookingObject) {
            return response()->json(['message' => 'Object not found'], 404);
        }

        if ($bookingObject->status !== ObjectStatus::FREE->value) {
            return response()->json(['message' => 'Object is not available for booking'], 403);
        }

        $newBooking = $this->createObjectReservation($user->id, $request->object_id);

        $bookingObject->update(['status' => ObjectStatus::RESERVED->value]);

        $newBooking->save();
        
        return response()->json(['message' => 'Object has been reserved'], 200);
    }

    public function bookObject (Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
            'booked_from' => 'required|date',
            'booked_to' => 'required|date',
            'user_id' => 'nullable|integer',
            'payment_status' => 'nullable|boolean',
        ]);

        $user = auth()->user();

        if ($request->user_id && !$this->userIsAdmin($user)) {
            return response()->json(['message' => 'Permission denied'], 403);
        }

        $bookingObject = BookingObject::where('id', $request->object_id)->first();

        if (!$bookingObject) {
            return response()->json(['message' => 'Object not found'], 404);
        }

        $userId = $request->user_id ?: $user->id;

        $userReservedBooking = Booking::where('user_id', $userId)
            ->where('object_id', $request->object_id)
            ->where('reserved_to', '>', Carbon::now())
            ->first();

        if (!$userReservedBooking && !$request->user_id) {
            return response()->json(['message' => 'Object is not pre-reserved'], 403);
        }

        if (!$userReservedBooking && $request->user_id) {
            $userReservedBooking = $this->createBooking($request->user_id, $request->object_id, $request->booked_from, $request->booked_to);
        } else {
            $userReservedBooking->update([
                'booked_from' => $request->booked_from,
                'booked_to' => $request->booked_to,
                'payment_status' => $request->payment_status ?: 1,
            ]);
        }

        $userReservedBooking->save();
        
        BookingObject::where('id', $request->object_id)
            ->update(['status' => ObjectStatus::BOOKED->value]);

        return response()->json(['message' => 'Object has been booked'], 200);
    }

    public function getBookingsByObjectId ($objectId)
    {
        $bookings = Booking::where('object_id', $objectId)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found'], 404);
        }

        return response()->json(['bookings' => $bookings], 200);
    }
}
