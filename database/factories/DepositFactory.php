<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deposit>
 */
class DepositFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'deposit_method_id' => 1,
            'invoice_id' => Str::random(15),
            'payment_method' => 'bank_transfer',
            'total' => $this->faker->numberBetween(1000, 10000),
            'fee' => $this->faker->numberBetween(100, 1000),
            'status' => 'pending'
        ];
    }
}
