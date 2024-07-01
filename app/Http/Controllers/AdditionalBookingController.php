<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use App\Enums\ObjectType;

class AdditionalBookingController extends Controller
{
        /**
     * Automatically change the objects status of expired reserved bookings.
     *
     * @return void
     */
    public static function updateExpiredReservedNotPaidBookingObjectStatus()
    {
        $bookedSunbedAndBedObjects = BookingObject::where(function ($query) {
            $query->where('type', ObjectType::SUNBED->value)
                  ->orWhere('type', ObjectType::BED->value);
            })
            ->where('status', '!=', ObjectStatus::FREE->value)
            ->count();
                
        $allSunbedAndBedObjects = BookingObject::where(function ($query) {
            $query->where('type', ObjectType::SUNBED->value)
                  ->orWhere('type', ObjectType::BED->value);
            })
            ->count();
        
        if ($bookedSunbedAndBedObjects == $allSunbedAndBedObjects) {
            // TODO
        }
    }
}
