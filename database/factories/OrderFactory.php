<?php

namespace Database\Factories;

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
            'user_id' => fake()->numberBetween(1, 10),
            'total_amount' => fake()->numberBetween(100, 999),
            'invoice_no' => fake()->randomLetter(),
            'order_date' => now(),
            'order_status' => "processing",
        ];
    }
}
