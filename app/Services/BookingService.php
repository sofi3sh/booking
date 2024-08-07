<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Illuminate\Support\Facades\Event;
use App\Services\AdditionalBookingService;
use App\Events\BookingObjectStatusUpdated;

class BookingService
{
    protected $additionalBookingService;

    public function __construct(AdditionalBookingService $additionalBookingService)
    {
        $this->additionalBookingService = $additionalBookingService;
    }

    private function createBooking ($userId, $objectId, $dateFrom, $dateTo, $paymentStatus, $description, $orderId, $price, $isChild, $isAdmin)
    {
        return new Booking([
            'user_id' => $userId,
            'object_id' => $objectId,
            'reserved_from' => Carbon::now(),
            'reserved_to' => Carbon::now(),
            'booked_from' => Carbon::parse($dateFrom)->startOfDay(),
            'booked_to' => Carbon::parse($dateTo)->endOfDay(),
            'payment_status' => $paymentStatus,
            'description' => $description,
            'order_id' => $orderId,
            'price' => $price,
            'is_child' => $isChild,
            'is_admin' => $isAdmin
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

    private function processBookingData($bookingData, $orderId, $isAdmin)
    {
        if ($bookingData['is_additional']) {
            return $this->additionalBookingService->createNewBooking([$bookingData], $orderId, $isAdmin);
        }

        $objectId = $bookingData['object_id'];
        $bookedFrom = $bookingData['booked_from'];
        $bookedTo = $bookingData['booked_to'];
        $userId = $bookingData['user_id'];
        $description = $bookingData['description'] ?? "";
        $price = $this->calculatePrice($objectId, $bookedFrom, $bookedTo, $bookingData['is_child']);

        $bookingObject = BookingObject::find($objectId);

        if (!$bookingObject) {
            return ['message' => __('object_not_found')];
        }

        if ($bookingObject->is_blocked) {
            return ['message' => __('object_is_blocked')];
        }

        $dateFromInStartDay = Carbon::parse($bookedFrom)->startOfDay();
        $dateToInEndDay = Carbon::parse($bookedTo)->endOfDay();

        if (!$this->isObjectAvailableToBook($objectId, $dateFromInStartDay, $dateToInEndDay)) {
            return ['message' => 'Object ' . $bookingObject->name . ' is not available for booking during the specified dates'];
        }

        $booking = $this->createBooking($userId, $objectId, $dateFromInStartDay, $dateToInEndDay, $bookingData['payment_status'], $description, $orderId, $price, $bookingData['is_child'], $isAdmin);
        $booking->save();

        $this->updateBookingObjectStatus($bookingObject, $bookedFrom);

        return $booking;
    }

    public function updateBookingObjectStatus($bookingObject, $bookedFrom)
    {
        $status = $bookedFrom < Carbon::now() ? ObjectStatus::BOOKED->value : ObjectStatus::FREE->value;
        $bookingObject->update(['status' => $status]);
        event(new BookingObjectStatusUpdated($bookingObject->id, $status));
    }
    public function customUpdateBookingObjectStatus($bookingObject, $status)
    {
        $bookingObject->update(['status' => $status]);
        event(new BookingObjectStatusUpdated($bookingObject->id, $status));
    }

    private function processBookingForExistingReserve($bookingData, $user, $orderId, $isAdmin)
    {
        if ($bookingData['is_additional']) {
            return $this->additionalBookingService->createNewBooking([$bookingData], $orderId, $isAdmin);
        }

        $objectId = $bookingData['object_id'];
        $bookedFrom = Carbon::parse($bookingData['booked_from'])->startOfDay();
        $bookedTo = Carbon::parse($bookingData['booked_to'])->endOfDay();
        $description = $bookingData['description'] ?? "";
        $price = $this->calculatePrice($objectId, $bookingData['booked_from'], $bookingData['booked_to'], $bookingData['is_child']);

        $bookingObject = BookingObject::find($objectId);

        if (!$bookingObject) {
            return ['message' => __('object_not_found')];
        }

        if ($bookingObject->is_blocked) {
            return ['message' => __('object_is_blocked')];
        }

        $existingBooking = $this->findExistingBooking($user->id, $objectId);

        if ($existingBooking) {
            $this->updateExistingBooking($existingBooking, $bookedFrom, $bookedTo, $description, $orderId, $price, $isAdmin);
            $booking = $existingBooking;
        } else {
            $booking = $this->createBooking($user->id, $objectId, $bookedFrom, $bookedTo, 0, $description, $orderId, $price, $bookingData['is_child'], $isAdmin);
            $booking->save();
        }

        $this->updateBookingObjectStatus($bookingObject, $bookedFrom);

        return $booking;
    }

    private function findExistingBooking($userId, $objectId)
    {
        return Booking::where('user_id', $userId)
            ->where('object_id', $objectId)
            ->where('reserved_to', '>', Carbon::now())
            ->first();
    }

    private function updateExistingBooking($existingBooking, $bookedFrom, $bookedTo, $description, $orderId, $price, $isAdmin)
    {
        $existingBooking->booked_from = $bookedFrom;
        $existingBooking->booked_to = $bookedTo;
        $existingBooking->payment_status = 1;
        $existingBooking->description = $description;
        $existingBooking->order_id = $orderId;
        $existingBooking->price = $price;
        $existingBooking->is_admin = $isAdmin;
        $existingBooking->save();
    }

    public function createNewBooking($bookingsData, $isAdmin)
    {
        $bookings = [];
        $orderId = strtoupper(uniqid());

        foreach ($bookingsData as $bookingData) {
            $response = $this->processBookingData($bookingData, $orderId, $isAdmin);
            $bookings[] = $response;
        }

        return $bookings;
    }

    public function bookExistingReserve($bookingsData, $user, $orderId, $isAdmin)
    {
        $bookings = [];

        foreach ($bookingsData as $bookingData) {
            $response = $this->processBookingForExistingReserve($bookingData, $user, $orderId, $isAdmin);
            $bookings[] = $response;
        }

        return $bookings;
    }

    public function calculatePrice ($objectId, $bookedFrom, $bookedTo, $isChild = false) : Float
    {
        $totalPrice = 0.0;

        $bookingObject = BookingObject::select('price', 'weekend_price', 'childrens_price', 'childrens_weekend_price', 'discount', 'discount_start_date', 'discount_end_date')->where('id', $objectId)->first();

        if (!$bookingObject) {
            return $totalPrice;
        }

        $bookingFrom = Carbon::parse($bookedFrom);
        $bookingTo = Carbon::parse($bookedTo);

        if ($bookingFrom > $bookingTo) {
            return $totalPrice;
        }

        $regularPrice = $isChild ? $bookingObject->childrens_price : $bookingObject->price;
        $weekendPrice = $isChild ? $bookingObject->childrens_weekend_price : $bookingObject->weekend_price;

        $weekends = 0;
        $weekdays = 0;

        $currentDay = clone $bookingFrom;

        while ($currentDay <= $bookingTo) {
            $dailyPrice = $regularPrice; // Default daily price

            if ($currentDay->isWeekend() || $currentDay->isFriday()) {
                $dailyPrice = $weekendPrice;
            }

            if (!empty($bookingObject->discount_start_date) && !empty($bookingObject->discount_end_date) && ($bookingObject->discount > 0 && $bookingObject->discount <= 100)) {
                if ($currentDay->between($bookingObject->discount_start_date, $bookingObject->discount_end_date)) {
                    $dailyPrice *= (1 - ($bookingObject->discount / 100)); // Apply discount
                }
            }

            $totalPrice += $dailyPrice;

            $currentDay->addDay();
        }

        return $totalPrice;
    }
}
