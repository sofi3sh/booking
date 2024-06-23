<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\BookingController;

Schedule::call(function () {
    BookingController::updateExpiredReservedNotPaidBookingObjectStatus();
})->everyMinute();

Schedule::call(function () {
    BookingController::updateExpiresBookedBookingObjectStatus();
})->at('00:00');

Schedule::call(function () {
    BookingController::updateBookedObjectsStatus();
})->at('00:01');

Schedule::call(function () {
    BookingController::sendNotificationWhenManyBookings();
})->at('09:00');
