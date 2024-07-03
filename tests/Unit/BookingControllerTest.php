<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\BookingObject;
use App\Enums\ObjectStatus;
use Carbon\Carbon;
use Mockery;
use Illuminate\Support\Facades\Event;
use App\Events\BookingObjectStatusUpdated;
use App\Models\User;
use App\Services\AdditionalBookingService;
use App\Services\BookingService;
use Illuminate\Support\Facades\Route;

class BookingControllerTest extends TestCase
{
    protected $user;
    protected $admin;
    protected $bookingServiceMock;
    protected $additionalBookingServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        $this->user = User::factory()->create(['role_id' => 2, 'phone_verified_at' => Carbon::now()]); // Regular user
        $this->admin = User::factory()->create(['role_id' => 1, 'phone_verified_at' => Carbon::now()]); // Admin user

        $this->bookingServiceMock = Mockery::mock(BookingService::class);
        $this->additionalBookingServiceMock = Mockery::mock(AdditionalBookingService::class);

        $this->app->instance(BookingService::class, $this->bookingServiceMock);
        $this->app->instance(AdditionalBookingService::class, $this->additionalBookingServiceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function testUpdateExpiredReservedNotPaidBookingObjectStatus()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::RESERVED->value,
        ]);

        $expiredBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'reserved_to' => Carbon::now()->subMinute(20),
            'order_id' => null,
        ]);

        \App\Http\Controllers\BookingController::updateExpiredReservedNotPaidBookingObjectStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::FREE->value,
        ]);

        Event::assertDispatched(BookingObjectStatusUpdated::class, function ($event) use ($bookingObject) {
            return $event->objectId === $bookingObject->id && $event->status === ObjectStatus::FREE->value;
        });
    }

    public function testNoUpdateForNonExpiredReservedBookings()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::RESERVED->value,
        ]);

        $nonExpiredBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'reserved_to' => Carbon::now()->addMinute(15),
            'order_id' => null,
        ]);

        \App\Http\Controllers\BookingController::updateExpiredReservedNotPaidBookingObjectStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::RESERVED->value,
        ]);

        Event::assertNotDispatched(BookingObjectStatusUpdated::class);
    }

    public function testNoUpdateForPaidBookings()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::RESERVED->value,
        ]);

        $paidBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'reserved_to' => Carbon::now()->subMinute(30),
            'order_id' => 'ORDER123',
        ]);

        \App\Http\Controllers\BookingController::updateExpiredReservedNotPaidBookingObjectStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::RESERVED->value,
        ]);

        Event::assertNotDispatched(BookingObjectStatusUpdated::class);
    }

    public function testUpdateExpiresBookedBookingObjectStatus()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::BOOKED->value,
        ]);

        $expiredBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'booked_to' => Carbon::now()->subDay(1),
        ]);

        \App\Http\Controllers\BookingController::updateExpiresBookedBookingObjectStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::FREE->value,
        ]);

        Event::assertDispatched(BookingObjectStatusUpdated::class, function ($event) use ($bookingObject) {
            return $event->objectId === $bookingObject->id && $event->status === ObjectStatus::FREE->value;
        });
    }

    public function testNoUpdateForNonExpiredBookedBookings()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::BOOKED->value,
        ]);

        $nonExpiredBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'booked_to' => Carbon::now()->addDay(1),
        ]);

        \App\Http\Controllers\BookingController::updateExpiresBookedBookingObjectStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        Event::assertNotDispatched(BookingObjectStatusUpdated::class);
    }

    public function testUpdateBookedObjectsStatus()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::RESERVED->value,
        ]);

        $currentBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'booked_from' => Carbon::now()->subDay(1),
            'booked_to' => Carbon::now()->addDay(1),
            'canceled' => false,
        ]);

        \App\Http\Controllers\BookingController::updateBookedObjectsStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        Event::assertDispatched(BookingObjectStatusUpdated::class, function ($event) use ($bookingObject) {
            return $event->objectId === $bookingObject->id && $event->status === ObjectStatus::BOOKED->value;
        });
    }

    public function testNoUpdateForNonBookedObjects()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::FREE->value,
        ]);

        $nonBookedBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'booked_from' => Carbon::now()->addDay(1),
            'booked_to' => Carbon::now()->addDay(10),
            'canceled' => false,
        ]);

        \App\Http\Controllers\BookingController::updateBookedObjectsStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::FREE->value,
        ]);

        Event::assertNotDispatched(BookingObjectStatusUpdated::class);
    }

    public function testNoUpdateForCanceledBookings()
    {
        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::BOOKED->value,
        ]);

        $canceledBooking = Booking::factory()->create([
            'object_id' => $bookingObject->id,
            'booked_from' => Carbon::now()->subday(1),
            'booked_to' => Carbon::now()->addDay(1),
            'canceled' => true,
        ]);

        \App\Http\Controllers\BookingController::updateBookedObjectsStatus();

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        Event::assertNotDispatched(BookingObjectStatusUpdated::class);
    }

    public function testIsBookingNotificationRequired()
    {
        $bookingObjects = BookingObject::factory()->count(10)->create();

        $bookedFrom = Carbon::now()->subDay(1);
        $bookedTo = Carbon::now()->addDay(1);

        foreach ($bookingObjects->take(9) as $bookingObject) {
            Booking::factory()->create([
                'object_id' => $bookingObject->id,
                'booked_from' => $bookedFrom,
                'booked_to' => $bookedTo,
            ]);
        }

        $result = \App\Http\Controllers\BookingController::isBookingNotificationRequired();

        $this->assertTrue($result);
    }

    public function testIsBookingNotificationNotRequired()
    {
        $bookingObjects = BookingObject::factory()->count(10)->create();

        $bookedFrom = Carbon::now()->subDay(1);
        $bookedTo = Carbon::now()->addDay(1);

        foreach ($bookingObjects->take(8) as $bookingObject) {
            Booking::factory()->create([
                'object_id' => $bookingObject->id,
                'booked_from' => $bookedFrom,
                'booked_to' => $bookedTo,
            ]);
        }

        $result = \App\Http\Controllers\BookingController::isBookingNotificationRequired();

        $this->assertFalse($result);
    }

    public function testIsBookingNotificationNotRequiredWithNoBookings()
    {
        BookingObject::factory()->count(10)->create();

        $result = \App\Http\Controllers\BookingController::isBookingNotificationRequired();

        $this->assertFalse($result);
    }

    public function testReserveObjectSuccess()
    {
        $this->actingAs($this->user, 'api');

        Event::fake();

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::FREE->value,
            'is_blocked' => false,
        ]);

        $response = $this->postJson('/api/booking/reserveObject', [
            'object_id' => $bookingObject->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => __('object_reserved')]);

        $this->assertDatabaseHas('booking_objects', [
            'id' => $bookingObject->id,
            'status' => ObjectStatus::RESERVED->value,
        ]);

        Event::assertDispatched(BookingObjectStatusUpdated::class, function ($event) use ($bookingObject) {
            return $event->objectId === $bookingObject->id && $event->status === ObjectStatus::RESERVED->value;
        });

        $this->assertDatabaseHas('bookings', [
            'object_id' => $bookingObject->id,
            'user_id' => $this->user->id,
            'payment_status' => 0,
        ]);
    }

    public function testReserveObjectNotFound()
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/booking/reserveObject', [
            'object_id' => 9999,
        ]);

        $response->assertStatus(404);
        $response->assertJson(['message' => __('object_not_found')]);
    }

    public function testReserveObjectBlocked()
    {
        $this->actingAs($this->user, 'api');

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::FREE->value,
            'is_blocked' => true,
        ]);

        $response = $this->postJson('/api/booking/reserveObject', [
            'object_id' => $bookingObject->id,
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => __('object_is_blocked')]);
    }

    public function testReserveObjectPhoneNotVerified()
    {
        $this->actingAs($this->user, 'api');

        $user = User::factory()->create(['phone_verified_at' => null]);
        $this->actingAs($user, 'api');

        $bookingObject = BookingObject::factory()->create([
            'status' => ObjectStatus::FREE->value,
            'is_blocked' => false,
        ]);

        $response = $this->postJson('/api/booking/reserveObject', [
            'object_id' => $bookingObject->id,
        ]);

        $response->assertStatus(403);
        $response->assertJson(['message' => __('verify_needed')]);
    }

    // NEED FIX V

    // public function testAdminBookObjectsSuccess()
    // {
    //     $this->actingAs($this->admin, 'api');

    //     $bookingObjects = BookingObject::factory()->count(2)->create();

    //     $this->bookingServiceMock->shouldReceive('createNewBooking')
    //         ->once()
    //         ->andReturn([
    //             Booking::factory()->make([
    //                 'object_id' => $bookingObjects[0]->id,
    //                 'user_id' => $this->user->id,
    //                 'payment_status' => true
    //             ])->toArray(),
    //             Booking::factory()->make([
    //                 'object_id' => $bookingObjects[1]->id,
    //                 'user_id' => $this->user->id,
    //                 'payment_status' => true
    //             ])->toArray()
    //         ]);

    //     $request = [
    //         [
    //             'object_id' => $bookingObjects[0]->id,
    //             'booked_from' => '2024-07-01',
    //             'booked_to' => '2024-07-05',
    //             'user_id' => $this->user->id,
    //             'payment_status' => false,
    //             'is_child' => false,
    //             'description' => 'Test Description 1',
    //             'is_additional' => false
    //         ],
    //         [
    //             'object_id' => $bookingObjects[1]->id,
    //             'booked_from' => '2024-07-01',
    //             'booked_to' => '2024-07-05',
    //             'user_id' => $this->user->id,
    //             'payment_status' => false,
    //             'is_child' => false,
    //             'description' => 'Test Description 2',
    //             'is_additional' => false
    //         ]
    //     ];

    //     $response = $this->postJson('/api/booking/admin/bookObjects', $request);

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure(['message', 'bookings']);
    //     $response->assertJson(['message' => __('objects_have_been_booked')]);

    //     foreach ($bookingObjects as $bookingObject) {
    //         $this->assertDatabaseHas('bookings', [
    //             'object_id' => $bookingObject->id,
    //             'user_id' => $this->user->id,
    //             'payment_status' => true,
    //         ]);
    //     }
    // }

    public function testAdminBookObjectsPermissionDenied()
    {
        $this->actingAs($this->user, 'api');

        $bookingObjects = BookingObject::factory()->count(2)->create();

        $request = [
            [
                'object_id' => $bookingObjects[0]->id,
                'booked_from' => '2024-07-01',
                'booked_to' => '2024-07-05',
                'user_id' => $this->user->id,
                'payment_status' => true,
                'is_child' => false,
                'description' => 'Test Description 1',
                'is_additional' => false
            ],
            [
                'object_id' => $bookingObjects[1]->id,
                'booked_from' => '2024-07-01',
                'booked_to' => '2024-07-05',
                'user_id' => $this->user->id,
                'payment_status' => true,
                'is_child' => false,
                'description' => 'Test Description 2',
                'is_additional' => false
            ]
        ];

        $response = $this->postJson('/api/booking/admin/bookObjects', $request);

        $response->assertStatus(403);
        $response->assertJson(['message' => __('permission_denied')]);

        foreach ($bookingObjects as $bookingObject) {
            $this->assertDatabaseMissing('bookings', [
                'object_id' => $bookingObject->id,
                'user_id' => $this->user->id,
            ]);
        }
    }

    public function testAdminBookObjectsValidationError()
    {
        $this->actingAs($this->admin, 'api');

        $bookingObjects = BookingObject::factory()->count(2)->create();

        $request = [
            [
                'object_id' => $bookingObjects[0]->id,
                // 'booked_from' is missing
                'booked_to' => '2024-07-05',
                'user_id' => $this->user->id,
                'payment_status' => true,
                'is_child' => false,
                'description' => 'Test Description 1',
                'is_additional' => false
            ],
            [
                'object_id' => $bookingObjects[1]->id,
                'booked_from' => '2024-07-01',
                'booked_to' => '2024-07-05',
                'user_id' => $this->user->id,
                'payment_status' => true,
                'is_child' => false,
                'description' => 'Test Description 2',
                'is_additional' => false
            ]
        ];

        $response = $this->postJson('/api/booking/admin/bookObjects', $request);

        $response->assertStatus(503);

        $responseData = $response->json();
        $this->assertEquals('The 0.booked_from field is required.', $responseData['message']);
    }

    public function testCancelOrderSuccess()
    {
        $this->actingAs($this->user, 'api');

        $booking = Booking::factory()->create([
            'order_id' => 'ORDER123',
            'canceled' => false,
        ]);

        $this->app['router']->post('/api/booking/cancelOrder', [\App\Http\Controllers\BookingController::class, 'cancelOrder']);

        $response = $this->postJson('/api/booking/cancelOrder', [
            'order_id' => 'ORDER123',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => __('order_has_been_canceled')]);

        $this->assertDatabaseHas('bookings', [
            'order_id' => 'ORDER123',
            'canceled' => true,
        ]);
    }

    public function testCancelOrderValidationError()
    {
        $this->actingAs($this->user, 'api');

        $this->app['router']->post('/api/booking/cancelOrder', [\App\Http\Controllers\BookingController::class, 'cancelOrder']);

        $response = $this->postJson('/api/booking/cancelOrder', []);

        $response->assertStatus(503);

        $responseData = $response->json();
        $this->assertEquals('The order id field is required.', $responseData['message']);
    }

    public function testGetBookingsByObjectIdSuccess()
    {
        $this->actingAs($this->user, 'api');

        $bookingObject = BookingObject::factory()->create();

        $bookings = Booking::factory()->count(2)->create([
            'object_id' => $bookingObject->id,
        ]);

        $this->app['router']->get('/api/booking/getBookingsByObjectId/{objectId}', [\App\Http\Controllers\BookingController::class, 'getBookingsByObjectId']);

        $response = $this->getJson("/api/booking/getBookingsByObjectId/{$bookingObject->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'bookings');
        $response->assertJsonStructure([
            'bookings' => [
                '*' => ['id', 'object_id', 'user_id', 'booked_from', 'booked_to', 'payment_status', 'canceled', 'created_at', 'updated_at']
            ]
        ]);
    }

    public function testGetBookingsByObjectIdNotFound()
    {
        $this->actingAs($this->user, 'api');

        $this->app['router']->get('/api/booking/getBookingsByObjectId/{objectId}', [\App\Http\Controllers\BookingController::class, 'getBookingsByObjectId']);

        $response = $this->getJson('/api/booking/getBookingsByObjectId/9999');

        $response->assertStatus(404);
        $response->assertJson(['message' => __('no_bookings_found')]);
    }

    public function testCalculateBookingPriceSuccess()
    {
        $this->actingAs($this->user, 'api');

        $bookingObject = BookingObject::factory()->create();

        $this->bookingServiceMock->shouldReceive('calculatePrice')
            ->once()
            ->with($bookingObject->id, '2024-07-01', '2024-07-05', false)
            ->andReturn(100.0);

        $this->app['router']->post('/api/booking/calculateBookingPrice', [\App\Http\Controllers\BookingController::class, 'calculateBookingPrice']);

        $response = $this->postJson('/api/booking/calculateBookingPrice', [
            'object_id' => $bookingObject->id,
            'booked_from' => '2024-07-01',
            'booked_to' => '2024-07-05',
            'is_child' => false,
            'is_additional' => false
        ]);

        $response->assertStatus(200);
        $response->assertJson(['price' => 100.0]);
    }
}
