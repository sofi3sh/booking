<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Carbon\Carbon;
use App\Services\BookingService;
use Vonage\Client;
use Vonage\SMS\Message\SMS;
use Vonage\Client\Credentials\Basic;

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

    /**
     * Automatically send notification for admin when 90% objects are booked.
     *
     * @return void
     */
    public static function sendNotificationWhenManyBookings ()
    {
        if (!$this->isBookingNotificationRequired()) {
            return;
        }

        $to = env('ADMIN_PHONE_NUMBER');
        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET_KEY'));
        $client = new Client($basic);

        $message = "!ALERT!\n\n" . 
           "90% of objects are booked today!";
        
        $client->sms()->send(
            new SMS($to, 'brand', $message)
        );
    }

    private function isBookingNotificationRequired ()
    {
        $currentDate = Carbon::now()->toDateString();
    
        $totalObjects = BookingObject::count();
    
        $bookedObjectsCount = Booking::whereDate('booked_from', '<=', $currentDate)
            ->whereDate('booked_to', '>=', $currentDate)
            ->count();
    
        $percentageBooked = ($bookedObjectsCount / $totalObjects) * 100;
    
        return $percentageBooked >= 90;
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
            'user_id' => $user->id,
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

    public function cancelOrder (Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        Booking::where('order_id', $request->order_id)
            ->update(['canceled' => 1]);

        return response()->json(['message' => 'Order has been canceled'], 200);
    }

    public function getBookingsByObjectId ($objectId)
    {
        $bookings = Booking::where('object_id', $objectId)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => 'No bookings found'], 404);
        }

        return response()->json(['bookings' => $bookings], 200);
    }

    public function calculateBookingPrice (Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
            'booked_from' => 'required|date',
            'booked_to' => 'required|date',
        ]);

        $totalPrice = 0.0;

        $bookingObject = BookingObject::select('price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date')->where('id', $request->object_id)->get();

        $bookingFrom = Carbon::parse($request->booked_from);
        $bookingTo = Carbon::parse($request->booked_to);
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

        return response()->json(['price' => $totalPrice], 200);
    }

    public function getOrder (Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $totalPrice = 0.0;

        $bookingsInOrder = Booking::where('order_id', $request->order_id)->get();

        if ($bookingsInOrder->isEmpty()) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        foreach ($bookingsInOrder as $booking) {
            $totalPrice += $booking->price;
        }

        return response()->json(['bookings' => $$bookingsInOrder, 'total_price' => $totalPrice], 200);
    }
}
