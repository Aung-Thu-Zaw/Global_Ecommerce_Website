<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'avatar' => fake()->imageUrl(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone'=>fake()->unique()->phoneNumber(),
            'address'=>fake()->address(),
            'status'=>fake()->randomElement(["active","inactive"]),
            'role'=>fake()->randomElement(["user","vendor"]),
            'shop_name'=>fake()->jobTitle(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            "created_at"=>fake()->dateTimeBetween("-2 months", now()),
            // "deleted_at"=>fake()->dateTimeBetween("-4 months", now())

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
