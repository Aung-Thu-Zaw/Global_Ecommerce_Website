<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendorProductBanner>
 */
class VendorProductBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id"=>3,
            "image"=>fake()->imageUrl(),
            "url"=>fake()->url(),
            "status"=>"show",
        ];
    }
}
