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
    public static function updateExpiredReservedNotPaidObjectStatus()
    {
        $expiredBookingObjectsIds = Booking::where('reserved_to', '<', Carbon::now())
            ->where('payment_status', 0)
            ->whereNull('booked_to')
            ->pluck('object_id');

        BookingObject::whereIn('id', $expiredBookingObjectsIds)
            ->update(['status' => ObjectStatus::FREE->value]);
    }

    /**
     * Automatically change the objects status of expired booked.
     *
     * @return void
     */
    public static function updateExpiresBookedObjectStatus()
    {
        $expiredBookingObjects = Booking::where('booked_to', '<', Carbon::now())
            ->orWhere(function ($query) {
                $query->where('booked_to', '>', Carbon::now())
                    ->where('booked_from', '<', Carbon::now())
                    ->where('canceled', 1);
            })
            ->pluck('object_id');

        BookingObject::whereIn('id', $expiredBookingObjects)
            ->update(['status' => ObjectStatus::FREE->value]);
    }

    /**
     * Automatically change the objects status of actual booked.
     *
     * @return void
     */
    public static function updateBookedObjectsStatus()
    {
        $bookedObjects = Booking::where('booked_to', '>', Carbon::now())
            ->where('booked_from', '<', Carbon::now())
            ->where('canceled', 0)
            ->pluck('object_id');

        BookingObject::whereIn('id', $bookedObjects)
            ->update(['status' => ObjectStatus::BOOKED->value]);
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
            'reserved_from' => Carbon::now(),
            'reserved_to' => Carbon::now(),
            'booked_from' => Carbon::parse($request->$dateFrom)->startOfDay(),
            'booked_to' => Carbon::parse($request->$dateTo)->endOfDay(),
            'payment_status' => $paymentStatus,
        ]);
    }

    private function isObjectAvailableToBook ($objectId, $dateFrom, $dateTo)
    {
        $bookingsForObject = Booking::where('object_id', $objectId)
        ->where(function ($query) use ($dateFrom, $dateTo) {
            $query->where(function ($q) use ($dateFrom, $dateTo) {
                $q->where('booked_from', '>=', $dateFrom)
                    ->where('booked_from', '<', $dateTo);
            })
            ->orWhere(function ($q) use ($dateFrom, $dateTo) {
                $q->where('booked_to', '>', $dateFrom)
                    ->where('booked_to', '<=', $dateTo);
            })
            ->orWhere(function ($q) use ($dateFrom, $dateTo) {
                $q->where('booked_from', '<', $dateFrom)
                    ->where('booked_to', '>', $dateTo);
            });
        })
        ->exists();

        return !$bookingsForObject;
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

        BookingObject::where('id', $request->object_id)
            ->update(['status' => ObjectStatus::RESERVED->value]);
        
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

        if (!$this->isObjectAvailableToBook($request->object_id, $request->booked_from, $request->booked_to)) {
            return response()->json(['message' => 'Object is not available for booking during the specified dates'], 403);
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

        $dateFromInStartDay = Carbon::parse($request->booked_from)->startOfDay();
        $dateToInEndDay = Carbon::parse($request->booked_to)->endOfDay();

        if (!$userReservedBooking && $request->user_id) {
            $userReservedBooking = $this->createBooking($request->user_id, $request->object_id, $dateFromInStartDay, $dateToInEndDay);
        } else {
            $userReservedBooking->booked_from = $dateFromInStartDay;
            $userReservedBooking->booked_to = $dateToInEndDay;
            $userReservedBooking->payment_status = $request->payment_status ?: 1;
        }

        $userReservedBooking->save();

        if ($request->booked_from < Carbon::now()) {
            BookingObject::where('id', $request->object_id)
                ->update(['status' => ObjectStatus::BOOKED->value]);
        } else {
            BookingObject::where('id', $request->object_id)
                ->update(['status' => ObjectStatus::FREE->value]);
        }

        return response()->json(['message' => 'Object have been booked successfully'], 200);
    }

    public function bookObjects (Request $request)
    {
        $request->validate([
            [
                'object_id' => 'required|integer',
                'booked_from' => 'required|date',
                'booked_to' => 'required|date',
                'user_id' => 'nullable|integer',
                'payment_status' => 'nullable|boolean',
            ]
        ]);

        foreach ($request as $objectBookingData) {
            $this->bookObject($objectBookingData);
        }

        return response()->json(['message' => 'Objects have been booked successfully'], 200);
    }

    public function cancelBooking (Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
        ]);

        Booking::where('id', $request->booking_id)
            ->update(['canceled' => 1]);

        return response()->json(['message' => 'Booking cancelled'], 200);
    }
}
