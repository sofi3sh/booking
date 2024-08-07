<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\AdditionalBooking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Carbon\Carbon;
use App\Events\BookingObjectStatusUpdated;
use Illuminate\Support\Facades\Event;
use App\Services\BookingService;
use App\Services\AdditionalBookingService;
use GuzzleHttp\Client;
use App\Models\Transaction;

class BookingController extends Controller
{
    protected $bookingService;
    protected $additionalBookingService;

    public function __construct(BookingService $bookingService, AdditionalBookingService $additionalBookingService)
    {
        $this->bookingService = $bookingService;
        $this->additionalBookingService = $additionalBookingService;
    }

    /**
     * Automatically change the objects status of expired reserved bookings.
     *
     * @return void
     */
    public static function updateExpiredReservedNotPaidBookingObjectStatus()
    {
        $expiredBookingObjectsIds = Booking::where('reserved_to', '<', Carbon::now())
            ->whereNull('order_id')
            ->whereHas('object', function ($query) {
                $query->where('status', ObjectStatus::RESERVED->value);
            })
            ->pluck('object_id')
            ->unique();

        $filteredObjectIds = $expiredBookingObjectsIds->filter(function ($objectId) {
            $activeReservationsCount = Booking::where('object_id', $objectId)
                ->where('reserved_to', '>=', Carbon::now())
                ->count();

            return $activeReservationsCount === 0;
        });

        BookingObject::whereIn('id', $filteredObjectIds)
            ->update(['status' => ObjectStatus::FREE->value]);

        foreach ($filteredObjectIds as $objectId) {
            event(new BookingObjectStatusUpdated($objectId, ObjectStatus::FREE->value));
        }
    }

    /**
     * Automatically change the objects status of expired booked.
     *
     * @return void
     */
    public static function updateExpiresBookedBookingObjectStatus()
    {
        $expiredBookingObjectsIds = Booking::where('booked_to', '<', Carbon::now())
            ->whereHas('object', function ($query) {
                $query->where('status', ObjectStatus::BOOKED->value);
            })
            ->distinct()
            ->pluck('object_id');

        BookingObject::whereIn('id', $expiredBookingObjectsIds)
            ->update(['status' => ObjectStatus::FREE->value]);

        foreach ($expiredBookingObjectsIds as $objectId) {
            event(new BookingObjectStatusUpdated($objectId, ObjectStatus::FREE->value));
        }
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
            ->whereHas('object', function ($query) {
                $query->where('status', '!=', ObjectStatus::BOOKED->value);
            })
            ->distinct()
            ->pluck('object_id');

        BookingObject::whereIn('id', $bookedObjects)
            ->update(['status' => ObjectStatus::BOOKED->value]);

        foreach ($bookedObjects as $objectId) {
            event(new BookingObjectStatusUpdated($objectId, ObjectStatus::BOOKED->value));
        }
    }


    /**
     * Automatically send notification for admin when 90% objects are booked.
     *
     * @return void
     */
    public static function sendNotificationWhenManyBookings ()
    {
        if (!self::isBookingNotificationRequired()) {
            return;
        }

        $baseUrl = 'https://a2p.vodafone.ua';
        $username = '380956139029';
        $password = 'STRe456892-=wr';
        $to = env('ADMIN_PHONE_NUMBER');

        $message = "!ALERT!\n\n" .
            "90% of objects are booked today!";

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post("{$baseUrl}/uaa/oauth/token", [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => $username,
                    'password' => $password,
                ],
                'headers' => [
                    'Authorization' => 'Basic aW50ZXJuYWw6aW50ZXJuYWw=',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];


            $response = $client->post("{$baseUrl}/communication-event/api/communicationManagement/v2/communicationMessage/send", [
                'json' => [
                    'content' => $message,
                    'type' => 'SMS',
                    'receiver' => [
                        [
                            'id' => 0,
                            'phoneNumber' => $to
                        ]
                    ],
                    'sender' => [
                        'id' => 'Pool Beach',
                        'name' => 'Pool Beach',
                        'phoneNumber' => '380956139029'
                    ],
                    'characteristic' => [
                        [
                            'name' => 'DISTRIBUTION.ID',
                            'value' => '5840964'
                        ],
                        [
                            'name' => 'VALIDITY.PERIOD',
                            'value' => '000000000900000R'
                        ]
                    ]
                ],
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();

            return response()->json([
                'error' => $responseBodyAsString,
            ], $response->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public static function isBookingNotificationRequired ()
    {
        $totalObjects = BookingObject::count();

        if ($totalObjects == 0) {
            return false;
        }

        $bookedObjectsCount = Booking::where('booked_from', '<=', Carbon::now())
            ->where('booked_to', '>=', Carbon::now())
            ->count();

        $percentageBooked = ($bookedObjectsCount / $totalObjects) * 100;

        return $percentageBooked >= 90;
    }

    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    private function userIsBookingAgent ($user)
    {
        return $user->role_id == 2;
    }

    private function getPriceCalculationService($isAdditional)
    {
        return $isAdditional ? $this->additionalBookingService : $this->bookingService;
    }

    public function reserveObject (Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
        ]);

        $user = auth()->user();

        if (!$user->phone_verified_at) {
            return response()->json(['message' => __('verify_needed')], 403);
        }

        $bookingObject = BookingObject::where('id', $request->object_id)->first();

        if (!$bookingObject) {
            return response()->json(['message' => __('object_not_found')], 404);
        }

        if ($bookingObject->is_blocked) {
            return response()->json(['message' => __('object_is_blocked')], 403);
        }

        $existReservation = Booking::where('user_id', $user->id)->where('reserved_to', '>', Carbon::now())->get('reserved_to')->first();

        $newBooking = new Booking ([
            'user_id' => $user->id,
            'object_id' => $request->object_id,
            'reserved_from' => Carbon::now(),
            'reserved_to' => $existReservation->reserved_to ?? Carbon::now()->addMinutes(15), // 3 min for test, replace to 15 in prod
            'payment_status' => 0,
        ]);

        $bookingObject->update(['status' => ObjectStatus::RESERVED->value]);
        event(new BookingObjectStatusUpdated($bookingObject->id, ObjectStatus::RESERVED->value));

        $newBooking->save();

        return response()->json(['message' => __('object_reserved')], 200);
    }

    public function adminbookObjects(Request $request)
    {
        $request->validate([
            '*.object_id' => 'required|integer',
            '*.booked_from' => 'required|date',
            '*.booked_to' => 'required|date',
            '*.user_id' => 'required|integer',
            '*.payment_status' => 'required|boolean',
            '*.is_child' => 'required|boolean',
            '*.description' => 'nullable|string',
            '*.is_additional' => 'required|boolean',
        ]);

        $isAdmin = true;

        $user = auth()->user();

        if (!$this->userIsAdmin($user) && !$this->userIsBookingAgent($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $bookings = $this->bookingService->createNewBooking($request->all(), $isAdmin);

        return response()->json(['message' => __('objects_have_been_booked'), 'bookings' => $bookings], 200);
    }

    public function cancelOrder (Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        Booking::where('order_id', $request->order_id)
            ->update(['canceled' => 1]);

        return response()->json(['message' => __('order_has_been_canceled')], 200);
    }

    public function getBookingsByObjectId ($objectId)
    {
        $bookings = Booking::where('object_id', $objectId)->get();

        if ($bookings->isEmpty()) {
            return response()->json(['message' => __('no_bookings_found')], 404);
        }

        return response()->json(['bookings' => $bookings], 200);
    }

    public function calculateBookingPrice(Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
            'booked_from' => 'required|date',
            'booked_to' => 'required|date|after_or_equal:booked_from',
            'is_child' => 'required|boolean',
            'is_additional' => 'required|boolean'
        ]);

        try {
            $price = $this->getPriceCalculationService($request->is_additional)
                ->calculatePrice($request->object_id, $request->booked_from, $request->booked_to, $request->is_child);

            return response()->json(['price' => $price], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error calculating price'], 500);
        }
    }

    public function getOrder (Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $totalPrice = 0.0;

        $bookingsInOrder = Booking::where('order_id', $request->order_id)->get();
        $additionalBookingsInOrder = AdditionalBooking::where('order_id', $request->order_id)->get();

        $allBookingsInOrger = $bookingsInOrder->merge($additionalBookingsInOrder);

        if ($bookingsInOrder->isEmpty()) {
            return response()->json(['message' => __('order_not_found')], 404);
        }

        $transactionStatus = Transaction::select('transaction_status')->where('order_id', $request->order_id)->first();

        foreach ($allBookingsInOrger as $booking) {
            $totalPrice += $booking->price;
        }

        return response()->json(['bookings' => $allBookingsInOrger, 'total_price' => $totalPrice, 'transaction_status' => $transactionStatus->transaction_status ?? null], 200);
    }

    public function deleteOrderById(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user) && !$this->userIsBookingAgent($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $bookings = Booking::where('order_id', $request->order_id)->get();

        $additionalookings = AdditionalBooking::where('order_id', $request->order_id)->get();

        if ($bookings->isEmpty() && $additionalookings->isEmpty()) {
            return response()->json(['message' => __('booking_not_found')], 404);
        }

        foreach ($bookings as $booking) {
            $bookingObject = BookingObject::find($booking->object_id);

            $booked_from = $booking->booked_from;
            $booking->delete();
            $this->bookingService->updateBookingObjectStatus($bookingObject, $booked_from);
        }

        foreach ($additionalookings as $additionalBooking) {
            $additionalBooking->delete();
        }


        return response()->json(['message' => __('booking_deleted_successfully')], 200);
    }
}
