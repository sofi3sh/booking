<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingObject;
use App\Models\AdditionalObject;
use App\Enums\ObjectStatus;
use App\Enums\ObjectType;
use App\Events\AdditionalObjectStatusUpdated;

class AdditionalBookingController extends Controller
{
    /**
     * Automatically updates the availability status of additional objects based on the status of all 
     * sunbed and bed bookings
     *
     * @return void
     */
    public static function updateAdditionalObjectAvailable()
    {
        $types = [ObjectType::SUNBED->value, ObjectType::BED->value];

        $bookedSunbedAndBedObjects = BookingObject::whereIn('type', $types)
            ->where('status', '!=', ObjectStatus::FREE->value)
            ->count();

        $allSunbedAndBedObjects = BookingObject::whereIn('type', $types)
            ->count();

        $isAvailable = $bookedSunbedAndBedObjects === $allSunbedAndBedObjects ? 1 : 0;
        AdditionalObject::query()->update(['is_available' => $isAvailable]);

        $additionalObjectIds = AdditionalObject::select('id')->get();

        foreach ($additionalObjectIds as $additionalObjectId) {
            event(new AdditionalObjectStatusUpdated($additionalObjectId, $isAvailable));
        }
    }
}
