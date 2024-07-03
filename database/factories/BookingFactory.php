<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BookingObject;

class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => uniqid(),
            'user_id' => \App\Models\User::factory(),
            'object_id' => \App\Models\BookingObject::factory(),
            'reserved_from' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'reserved_to' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'booked_from' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'booked_to' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'payment_status' => false,
            'canceled' => false,
        ];
    }
}
