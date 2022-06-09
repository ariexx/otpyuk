<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
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
            'operator_id' => 1,
            'service_id' => $this->faker->numberBetween(1, 10),
            'provider_order_id' => Str::random(15),
            'order_id' => Str::random(10),
            'phone_number' => $this->faker->phoneNumber,
            'sms_message' => $this->faker->text(30),
            'status' => rand(0, 3),
            'start_at' => now(),
            'expires_at' => now()->addMinutes(20)
        ];
    }
}
