<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => $this->faker->uuid,
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'fee' => $this->faker->randomFloat(2, 0, 100),
            'issuer_bank_name' => $this->faker->company,
            'card' => $this->faker->creditCardNumber,
            'transaction_status' => 'Pending',
        ];
    }
}
