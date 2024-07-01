<?php

namespace Database\Factories;

use App\Models\AdditionalObject;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalObjectFactory extends Factory
{
    protected $model = AdditionalObject::class;

    public function definition()
    {
        return [
            'name_ua' => $this->faker->word,
            'name_en' => $this->faker->word,
            'description_ua' => $this->faker->sentence,
            'description_en' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(50, 200),
            'weekend_price' => $this->faker->numberBetween(100, 300),
            'childrens_price' => $this->faker->numberBetween(30, 100),
            'childrens_weekend_price' => $this->faker->numberBetween(50, 150),
        ];
    }
}
