<?php

namespace Database\Seeders;

use App\Models\ProductBanner;
use Illuminate\Database\Seeder;

class ProductBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductBanner::factory()->create(["image"=>"product-banner-4.jpg"]);
        ProductBanner::factory()->create(["image"=>"product-banner-5.jpg"]);
        ProductBanner::factory()->create(["image"=>"product-banner-6.jpg"]);
    }
}
