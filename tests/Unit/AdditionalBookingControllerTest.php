<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\BookingObject;
use App\Models\AdditionalObject;
use App\Enums\ObjectStatus;
use App\Enums\ObjectType;
use Illuminate\Support\Facades\Event;
use App\Events\AdditionalObjectStatusUpdated;

class AdditionalBookingControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();        
        Event::fake();
    }

    public function testUpdateAdditionalObjectAvailableAllBooked()
    {
        BookingObject::factory()->count(5)->create([
            'type' => ObjectType::SUNBED->value,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        BookingObject::factory()->count(5)->create([
            'type' => ObjectType::BED->value,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        AdditionalObject::factory()->count(3)->create(['is_available' => 1]);

        \App\Http\Controllers\AdditionalBookingController::updateAdditionalObjectAvailable();

        $this->assertDatabaseHas('additional_objects', ['is_available' => 1]);

        Event::assertDispatched(AdditionalObjectStatusUpdated::class, function ($event) {
            return $event->isAvailable === 1;
        });
    }

    public function testUpdateAdditionalObjectAvailableNotAllBooked()
    {
        BookingObject::factory()->count(4)->create([
            'type' => ObjectType::SUNBED->value,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        BookingObject::factory()->count(1)->create([
            'type' => ObjectType::SUNBED->value,
            'status' => ObjectStatus::FREE->value,
        ]);

        BookingObject::factory()->count(4)->create([
            'type' => ObjectType::BED->value,
            'status' => ObjectStatus::BOOKED->value,
        ]);

        BookingObject::factory()->count(1)->create([
            'type' => ObjectType::BED->value,
            'status' => ObjectStatus::FREE->value,
        ]);

        AdditionalObject::factory()->count(3)->create(['is_available' => 1]);

        \App\Http\Controllers\AdditionalBookingController::updateAdditionalObjectAvailable();

        $this->assertDatabaseHas('additional_objects', ['is_available' => 0]);

        Event::assertDispatched(AdditionalObjectStatusUpdated::class, function ($event) {
            return $event->isAvailable === 0;
        });
    }
}
