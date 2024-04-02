<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\BookingController;

Schedule::call(function () {
    BookingController::updateExpiredReservedNotPaidObjectStatus();
})->everyMinute();

Schedule::call(function () {
    BookingController::updateExpiresBookedObjectStatus();
})->at('00:00:01');

Schedule::call(function () {
    BookingController::updateBookedObjectsStatus();
})->at('00:01');
