<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingObjectController;
use App\Http\Controllers\BookingController;

Route::prefix('auth')
->controller(AuthController::class)
->middleware('throttle:password_access')
->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login')->name('login');
    Route::post('/verify', 'verify');
    Route::post('/sendVerificationCode', 'sendVerificationCode');
    Route::post('/resetPassword', 'resetPassword');
    Route::middleware('auth:api')->post('/logout', 'logout');
});

Route::prefix('user')
->middleware('auth:api')
->controller(UserController::class)
->group(function () {
    Route::get('/getProfile', 'getProfile');
    Route::post('/updateProfile', 'updateProfile');
    Route::get('/getUserBookings', 'getUserBookings');
});

Route::resource('objects', BookingObjectController::class)->only(['index', 'show']);
Route::get('objects/{id}/getBookingsByObjectId', [BookingController::class, 'getBookingsByObjectId']);

Route::prefix('admin')
->middleware('auth:api')
->controller(UserController::class)
->group(function () {
    Route::get('/getUsers', 'adminGetUsers');
    Route::get('/getBookingAgents', 'adminGetBookingAgents');
    Route::post('/editUser', 'adminEditUser');
});

Route::prefix('admin')
->middleware('auth:api')
->group(function () {
    Route::resource('objects', BookingObjectController::class)->only(['store', 'destroy']);
    Route::post('objects/{id}', [BookingObjectController::class, 'update']);
});

Route::prefix('booking')
->middleware('auth:api')
->controller(BookingController::class)
->group(function () {
    Route::post('/reserveObject', 'reserveObject');
    Route::post('/bookObjects', 'bookObjects');
    Route::post('/cancelBooking', 'cancelBooking');
});
