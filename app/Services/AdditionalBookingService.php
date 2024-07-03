<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\AdditionalObject;
use App\Models\AdditionalBooking;

class AdditionalBookingService
{
    private function createBooking ($userId, $objectId, $dateFrom, $dateTo, $paymentStatus, $description, $isChild, $orderId, $price, $isAdmin)
    {
        return new AdditionalBooking([
            'user_id' => $userId,
            'additional_object_id' => $objectId,
            'booked_from' => Carbon::parse($dateFrom)->startOfDay(),
            'booked_to' => Carbon::parse($dateTo)->endOfDay(),
            'payment_status' => $paymentStatus,
            'description' => $description,
            'is_child' => $isChild,
            'order_id' => $orderId,
            'price' => $price,
            'is_admin' => $isAdmin
        ]);
    }

    private function processBookingData($bookingData, $orderId, $isAdmin)
    {
        $objectId = $bookingData['object_id'];
        $bookedFrom = $bookingData['booked_from'];
        $bookedTo = $bookingData['booked_to'];
        $userId = $bookingData['user_id'];
        $description = $bookingData['description'] ?? "";
        $price = $this->calculatePrice($objectId, $bookedFrom, $bookedTo, $bookingData['is_child']);

        $bookingObject = AdditionalObject::find($objectId);

        if (!$bookingObject) {
            return ['message' => __('object_not_found')];
        }

        if ($bookingObject->is_available) {
            return ['message' => __('object_is_blocked')];
        }

        $dateFromInStartDay = Carbon::parse($bookedFrom)->startOfDay();
        $dateToInEndDay = Carbon::parse($bookedTo)->endOfDay();

        $booking = $this->createBooking($userId, $objectId, $dateFromInStartDay, $dateToInEndDay, $bookingData['payment_status'], $description, $bookingData['is_child'], $orderId, $price, $isAdmin);
        $booking->save();

        return $booking;
    }

    public function calculatePrice($additionalObjectId, $bookedFrom, $bookedTo, $isChild = false): float
    {
        $totalPrice = 0.0;
    
        $additionalObject = AdditionalObject::find($additionalObjectId, ['price', 'weekend_price', 'childrens_price', 'childrens_weekend_price']);

        if (!$additionalObject) {
            return $totalPrice;
        }
    
        $bookingFrom = Carbon::parse($bookedFrom);
        $bookingTo = Carbon::parse($bookedTo);
    
        if ($bookingFrom > $bookingTo) {
            return $totalPrice;
        }
    
        $regularPrice = $isChild ? $additionalObject->childrens_price : $additionalObject->price;
        $weekendPrice = $isChild ? $additionalObject->childrens_weekend_price : $additionalObject->weekend_price;
    
        for ($currentDay = $bookingFrom; $currentDay <= $bookingTo; $currentDay->addDay()) {
            $dailyPrice = $currentDay->isWeekend() ? $weekendPrice : $regularPrice;
            $totalPrice += $dailyPrice;
        }
    
        return $totalPrice;
    }

    public function createNewBooking($additionalBookingsData, $orderId, $isAdmin)
    {
        $additionalBookings = [];

        foreach ($additionalBookingsData as $bookingData) {
            $response = $this->processBookingData($bookingData, $orderId, $isAdmin);
            $bookings[] = $response;
        }

        return $bookings;
    }
}