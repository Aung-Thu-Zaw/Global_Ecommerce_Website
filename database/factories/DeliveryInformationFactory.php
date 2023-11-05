<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryInformation>
 */
class DeliveryInformationFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'country' => 'Myanmar',
            'region' => 'Tanintharyi',
            'city' => 'Myeik',
            'township' => 'Myeik',
            'postal_code' => '14051',
            'additional_information' => fake()->paragraph(),
        ];
    }
}
