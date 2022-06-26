<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'provider_id' => $this->faker->numberBetween(1, 50),
            'operator_id' => 1,
            'rate_id' => 1,
            'service_name' => $this->faker->word,
            'provider_price' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->numberBetween(1, 2000),
            'discount' => '0',
            'discount_percentage' => 0,
            'is_active' => '1',
        ];
    }
}
