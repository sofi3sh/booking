<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Carbon\Carbon;
use App\Services\BookingService;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

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

    public function adminbookObjects (Request $request)
    {
        $request->validate([
            '*.object_id' => 'required|integer',
            '*.booked_from' => 'required|date',
            '*.booked_to' => 'required|date',
            '*.user_id' => 'required|integer',
            '*.payment_status' => 'required|boolean',
            '*.description' => 'nullable|string',
        ]);
    
        $user = auth()->user();
        
        $bookings = $this->bookingService->createNewBooking($request->all());

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

    public function calculatePriceForBooking ($objectId, $dateFrom, $dateTo)
    {
        $totalPrice = 0.0;

        $bookingObject = BookingObject::select('price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date')->where('id', $objectId)->get();

        $bookingFrom = Carbon::parse($dateFrom);
        $bookingTo = Carbon::parse($dateTo);
        $discountStartDate = Carbon::parse($bookingObject->discount_start_date);
        $discountEndDate = Carbon::parse($bookingObject->discount_end_date);

        $weekends = $bookingFrom->diffInDaysFiltered(function ($date) {
            return $date->isWeekend();
        }, $bookingTo);

        $weekdays = $bookingFrom->diffInDaysFiltered(function ($date) {
            return $date->isWeekday();
        }, $bookingTo);

        $totalPrice += $weekends * $bookingObject->price;
        $totalPrice += $weekends * $bookingObject->weekend_price;

        // Check if the booking period falls within the discount period
        if ($bookingFrom->between($discountStartDate, $discountEndDate) || 
            $bookingTo->between($discountStartDate, $discountEndDate) ||
            ($bookingFrom <= $discountStartDate && $bookingTo >= $discountEndDate)) {
            $discountPercentage = $bookingObject->discount / 100;

            $totalPrice -= $totalPrice * $discountPercentage;
        }

        return $totalPrice;
    }
}
