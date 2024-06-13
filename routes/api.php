<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingObjectController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OneCController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ObjectDetailsController;
use App\Http\Controllers\RoleController;


Route::prefix('auth')
    ->controller(AuthController::class)
    ->middleware('throttle:password_access')
    ->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
        Route::post('/verify', 'verify');
        Route::post('/sendVerificationCode', 'sendVerificationCode');
        Route::middleware('auth:api')->post('/logout', 'logout');
    });

Route::prefix('user')
    ->middleware('auth:api')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/getProfile', 'getProfile');
        Route::post('/updateProfile', 'updateProfile');
        Route::post('/resetPassword', 'resetPassword');
        Route::get('/getUserBookings', 'getUserBookings');
    });

Route::resource('objects', BookingObjectController::class)->only(['show']);

Route::post('objects/showAll', [BookingObjectController::class, 'index']);

Route::get('objects/{id}/getBookingsByObjectId', [BookingController::class, 'getBookingsByObjectId']);
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('objects/{id}/reviews/showAllByObjectId', [ReviewController::class, 'showAllByObjectId']);

Route::prefix('objects')
    ->controller(BookingObjectController::class)
    ->group(function () {
        Route::post('/getAvailableObjectsByDate', 'getAvailableObjectsByDate');
        Route::get('/{id}/details/showAllByObjectId', [ObjectDetailsController::class, 'showAllByObjectId']);
    });

Route::prefix('objects')
->middleware('auth:api')
->controller(ReviewController::class)
->group(function () {
    Route::post('/{id}/reviews', 'store');
});

Route::prefix('admin')
    ->middleware('auth:api')
    ->group(function () {
        Route::get('/getUsers', [UserController::class, 'adminGetUsers']);
        Route::get('/getBookingAgents', [UserController::class, 'adminGetBookingAgents']);
        Route::post('/editUser', [UserController::class, 'adminEditUser']);
        Route::post('/adminBlockUser', [UserController::class, 'adminBlockUser']);
        
        Route::get('/getRoles', [RoleController::class, 'index']);
    });

Route::prefix('admin')
    ->middleware('auth:api')
    ->group(function () {
        Route::resource('objects', BookingObjectController::class)->only(['store', 'destroy']);
        Route::post('objects/{id}', [BookingObjectController::class, 'update']);
        Route::post('objects/{id}/deletePhotosByName', [BookingObjectController::class, 'deletePhotosByName']);
        Route::post('objects/{id}/addObjectPhotos', [BookingObjectController::class, 'addObjectPhotos']);
        Route::resource('objectDetails', ObjectDetailsController::class)->only(['index', 'store', 'destroy', 'update', 'show']);
    });

Route::prefix('booking')
    ->middleware('auth:api')
    ->controller(BookingController::class)
    ->group(function () {
        Route::post('/reserveObject', 'reserveObject');
        Route::post('/calculateBookingPrice', 'calculateBookingPrice');
        Route::post('/cancelOrder', 'cancelOrder');
        Route::post('/getOrder', 'getOrder');
    });

Route::prefix('booking')
    ->middleware('auth:api')
    ->controller(BookingController::class)
    ->group(function () {
        Route::prefix('admin')
            ->group(function () {
                Route::post('/bookObjects', 'adminBookObjects');
            });
    });

// one C routes

Route::prefix('onec')->group(function () {
    Route::prefix('objects')->controller(OneCController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/updateObject/{id}', 'update');
        Route::post('/updateAllByType', 'updateAllByType');
    });

    Route::prefix('booking')->controller(OneCController::class)->group(function () {
        Route::post('/getLastOrdersByDays', 'getLastOrdersByDays');
        Route::post('/getLastTransactionsByDays', 'getLastTransactionsByDays');
    });
});

// payment test

Route::post('/preparePaymentData', [PaymentController::class, 'preparePaymentData']);

