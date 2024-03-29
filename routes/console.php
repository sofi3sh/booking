<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\BookingController;

Schedule::call(function () {
    BookingController::updateExpiredReservedNotPaidBookingObjectStatus();
})->everyMinute();

Schedule::call(function () {
    BookingController::updateExpiredReservedNotPaidBookingObjectStatus();
})->at('00:00');
