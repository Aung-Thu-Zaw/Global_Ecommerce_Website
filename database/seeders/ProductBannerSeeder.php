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
        ProductBanner::factory()->create(["image"=>"product-banner-1.jpg"]);
        ProductBanner::factory()->create(["image"=>"product-banner-2.jpg"]);
        ProductBanner::factory()->create(["image"=>"product-banner-3.jpg"]);
    }
}
