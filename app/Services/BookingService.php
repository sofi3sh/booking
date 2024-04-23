<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;

class BookingService
{
    private function createBooking ($userId, $objectId, $dateFrom, $dateTo, $paymentStatus, $description, $orderId, $price)
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

    public function createNewBooking ($bookingsData)
    {
        $bookings = [];

        $orderId = strtoupper(uniqid());

        foreach ($bookingsData as $bookingData) {
            $objectId = $bookingData['object_id'];
            $bookedFrom = $bookingData['booked_from'];
            $bookedTo = $bookingData['booked_to'];
            $userId = $bookingData['user_id'];
            $description = $bookingData['description'] ?? "";
            $price = $this->calculatePrice($objectId, $bookedFrom, $bookedTo);

            $bookingObject = BookingObject::find($objectId);

            if (!$bookingObject) {
                $bookings[] = ['message' => __('object_not_found')];
                continue;
            }

            if ($bookingObject->is_blocked) {
                $bookings[] = ['message' => __('object_is_blocked')];
                continue;
            }

            $dateFromInStartDay = Carbon::parse($bookedFrom)->startOfDay();
            $dateToInEndDay = Carbon::parse($bookedTo)->endOfDay();

            if (!$this->isObjectAvailableToBook($objectId, $dateFromInStartDay, $dateToInEndDay)) {
                $bookings[] = ['message' => 'Object ' . $bookingObject->name . ' is not available for booking during the specified dates'];
                continue;
            }
        
            $booking = $this->createBooking($userId, $objectId, $dateFromInStartDay, $dateToInEndDay, $bookingData['payment_status'], $description, $orderId, $price);
            $booking->save();
        
            if ($bookedFrom < Carbon::now()) {
                $bookingObject->update(['status' => ObjectStatus::BOOKED->value]);
            } else {
                $bookingObject->update(['status' => ObjectStatus::FREE->value]);
            }
    
            $bookings[] = $booking;
        }

        return $bookings;
    }

    public function bookExistingReserve ($bookingsData, $user, $orderId)
    {
        $bookings = [];
    
        foreach ($bookingsData as $bookingData) {
            $objectId = $bookingData['object_id'];
            $bookedFrom = $bookingData['booked_from'];
            $bookedTo = $bookingData['booked_to'];
            $userId = $user->id;
            $description = $bookingData['description'] ?? "";
            $price = $this->calculatePrice($objectId, $bookedFrom, $bookedTo);

            $bookingObject = BookingObject::find($objectId);

            $dateFromInStartDay = Carbon::parse($bookedFrom)->startOfDay();
            $dateToInEndDay = Carbon::parse($bookedTo)->endOfDay();

            $existingBooking = Booking::where('user_id', $userId)
                ->where('object_id', $objectId)
                ->where('reserved_to', '>', Carbon::now())
                ->first();
                
            if (!empty($existingBooking)){
                $existingBooking->booked_from = $dateFromInStartDay;
                $existingBooking->booked_to = $dateToInEndDay;
                $existingBooking->payment_status = 1;
                $existingBooking->description = $description;
                $existingBooking->order_id = $orderId;
                $existingBooking->price = $price;
                $existingBooking->save();
                $booking = $existingBooking;
            } else {
                $booking = $this->createBooking($userId, $objectId, $dateFromInStartDay, $dateToInEndDay, 1, $description, $orderId, $price);
                $booking->save();    
            }
        
            if ($bookedFrom < Carbon::now()) {
                $bookingObject->update(['status' => ObjectStatus::BOOKED->value]);
            } else {
                $bookingObject->update(['status' => ObjectStatus::FREE->value]);
            }
    
            $bookings[] = $booking;
        }

        return $bookings;
    }

    public function calculatePrice ($objectId, $bookedFrom, $bookedTo) : Float
    {
        $totalPrice = 0.0;

        $bookingObject = BookingObject::select('price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date')->where('id', $objectId)->first();

        if (!$bookingObject) {
            return $totalPrice;
        }
        
        $bookingFrom = Carbon::parse($bookedFrom);
        $bookingTo = Carbon::parse($bookedTo);

        if ($bookingFrom > $bookingTo) {
            return $totalPrice;
        }

        $weekends = 0;
        $weekdays = 0;

        $currentDay = clone $bookingFrom;

        while ($currentDay <= $bookingTo) {
            $dailyPrice = $bookingObject->price; // Default daily price
        
            if ($currentDay->isWeekend()) {
                $dailyPrice = $bookingObject->weekend_price;
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
