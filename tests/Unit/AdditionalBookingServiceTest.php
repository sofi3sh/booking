<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\AdditionalBookingService;
use App\Models\AdditionalObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AdditionalBookingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->additionalBookingService = new AdditionalBookingService();
    }

    public function test_calculate_price_with_regular_days()
    {
        $additionalObject = AdditionalObject::factory()->create([
            'price' => 100,
            'weekend_price' => 150,
            'childrens_price' => 50,
            'childrens_weekend_price' => 75,
        ]);

        $bookedFrom = '2024-07-03';
        $bookedTo = '2024-07-07'; // 5 days including a weekend

        $price = $this->additionalBookingService->calculatePrice($additionalObject->id, $bookedFrom, $bookedTo, false);

        $expectedPrice = (3 * 100) + (2 * 150); // 3 weekdays and 2 weekend days

        $this->assertEquals($expectedPrice, $price);
    }

    public function test_calculate_price_with_children_rates()
    {
        $additionalObject = AdditionalObject::factory()->create([
            'price' => 100,
            'weekend_price' => 150,
            'childrens_price' => 50,
            'childrens_weekend_price' => 75,
        ]);

        $bookedFrom = '2024-07-01';
        $bookedTo = '2024-07-05'; // 5 weekdays

        $price = $this->additionalBookingService->calculatePrice($additionalObject->id, $bookedFrom, $bookedTo, true);

        $expectedPrice = (5 * 50); // 5 weekdays

        $this->assertEquals($expectedPrice, $price);
    }

    public function test_calculate_price_only_weekends()
    {
        $additionalObject = AdditionalObject::factory()->create([
            'price' => 100,
            'weekend_price' => 150
        ]);

        $bookedFrom = '2024-07-06';
        $bookedTo = '2024-07-07'; // 2 weekends

        $price = $this->additionalBookingService->calculatePrice($additionalObject->id, $bookedFrom, $bookedTo, false);

        $expectedPrice = (2 * 150); // 2 weekends

        $this->assertEquals($expectedPrice, $price);
    }

    public function test_calculate_price_with_invalid_dates()
    {
        $additionalObject = AdditionalObject::factory()->create([
            'price' => 100,
            'weekend_price' => 150,
            'childrens_price' => 50,
            'childrens_weekend_price' => 75,
        ]);

        $bookedFrom = '2024-07-05';
        $bookedTo = '2024-07-01'; // Invalid date range

        $price = $this->additionalBookingService->calculatePrice($additionalObject->id, $bookedFrom, $bookedTo);

        $this->assertEquals(0.0, $price);
    }

    public function test_calculate_price_with_nonexistent_object()
    {
        $bookedFrom = '2024-07-01';
        $bookedTo = '2024-07-05';

        $price = $this->additionalBookingService->calculatePrice(9999, $bookedFrom, $bookedTo); // Nonexistent object

        $this->assertEquals(0.0, $price);
    }
}
