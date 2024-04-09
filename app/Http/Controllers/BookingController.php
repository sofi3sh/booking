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

    private function createBooking ($userId, $objectId, $dateFrom, $dateTo, $paymentStatus, $description)
    {
        return new Booking ([
            'user_id' => $userId,
            'object_id' => $objectId,
            'reserved_from' => Carbon::now(),
            'reserved_to' => Carbon::now(),
            'booked_from' => Carbon::parse($dateFrom)->startOfDay(),
            'booked_to' => Carbon::parse($dateTo)->endOfDay(),
            'payment_status' => $paymentStatus,
            'description' => $description,
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

    public function bookObjects (Request $request)
    {
        $request->validate([
            '*.object_id' => 'required|integer',
            '*.booked_from' => 'required|date',
            '*.booked_to' => 'required|date',
            '*.user_id' => 'nullable|integer',
            '*.payment_status' => 'nullable|boolean',
            '*.description' => 'nullable|string',
        ]);
    
        $user = auth()->user();
    
        $bookings = [];

        $orderId = strtoupper(uniqid());
    
        foreach ($request->all() as $bookingData) {
            $objectId = $bookingData['object_id'];
            $bookedFrom = $bookingData['booked_from'];
            $bookedTo = $bookingData['booked_to'];
            $userId = $bookingData['user_id'] ?? $user->id;
            $description = $bookingData['description'] ?? "";
    
            if (!empty($bookingData['user_id']) && !$this->userIsAdmin($user)) {
                return response()->json(['message' => 'Permission denied'], 403);
            }

            $bookingObject = BookingObject::find($objectId);

            if (!$bookingObject) {
                return response()->json(['message' => 'Object not found'], 404);
            }

            if (!$this->isObjectAvailableToBook($objectId, $bookedFrom, $bookedTo)) {
                return response()->json(['message' => 'Object ' . $bookingObject->name . ' is not available for booking during the specified dates'], 403);
            }

            $existingBooking = Booking::where('user_id', $userId)
                ->where('object_id', $objectId)
                ->where('reserved_to', '>', Carbon::now())
                ->first();
    
            $dateFromInStartDay = Carbon::parse($bookedFrom)->startOfDay();
            $dateToInEndDay = Carbon::parse($bookedTo)->endOfDay();
    
            if (empty($existingBooking) && !empty($bookingData['user_id'])) {
                $booking = $this->createBooking($userId, $objectId, $dateFromInStartDay, $dateToInEndDay, $bookingData['payment_status'] ?? 1, $description, $orderId);
                $booking->save();
            }
            
            if (!empty($existingBooking)){
                $existingBooking->booked_from = $dateFromInStartDay;
                $existingBooking->booked_to = $dateToInEndDay;
                $existingBooking->payment_status = $bookingData['payment_status'] ?? 1;
                $existingBooking->description = $description;
                $existingBooking->order_id = $orderId;
                $existingBooking->save();
                $booking = $existingBooking;
            } else {
                return response()->json(['message' => 'Booking must be reserved', 'bookings' => $bookings], 200);
            }
        
            if ($bookedFrom < Carbon::now()) {
                $bookingObject->update(['status' => ObjectStatus::BOOKED->value]);
            } else {
                $bookingObject->update(['status' => ObjectStatus::FREE->value]);
            }
    
            $bookings[] = $booking;
        }
    
        return response()->json(['message' => 'Objects have been booked successfully', 'bookings' => $bookings], 200);
    }

    public function cancelBooking (Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
        ]);

        Booking::where('id', $request->booking_id)
            ->update(['canceled' => 1]);

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
