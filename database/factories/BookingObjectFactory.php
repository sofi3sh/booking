<?php

namespace Database\Factories;

use App\Models\BookingObject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingObjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookingObject::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_ua' => $this->faker->word,
            'name_en' => $this->faker->word,
            'description_ua' => $this->faker->optional()->paragraph,
            'description_en' => $this->faker->optional()->paragraph,
            'price' => $this->faker->randomFloat(2, 100, 1000),
            'weekend_price' => $this->faker->randomFloat(2, 100, 1000), // Ensure this field is populated
            'discount' => $this->faker->numberBetween(0, 100), // Ensure this field is populated
            'discount_start_date' => $this->faker->optional()->date,
            'discount_end_date' => $this->faker->optional()->date,
            'zone' => $this->faker->randomElement(['bungalow', 'pool', 'cottages']), // Ensure this field is populated
            'status' => $this->faker->randomElement(['free', 'reserved', 'booked']), // Ensure this field is populated
            'type' => $this->faker->randomElement(['sunbed', 'bed', 'bungalow', 'second bungalow', 'little cottage', 'big cottage']), // Ensure this field is populated
            'preview_photo' => $this->faker->optional()->imageUrl(640, 480, 'preview', true),
            'photos' => json_encode([$this->faker->optional()->imageUrl(640, 480, 'photo', true)]),
            'max_persons' => $this->faker->optional()->numberBetween(1, 10),
            'location' => $this->faker->optional()->address,
            'position' => $this->faker->optional()->numberBetween(1, 100),
            'childrens_price' => $this->faker->randomFloat(2, 50, 500),
            'childrens_weekend_price' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
