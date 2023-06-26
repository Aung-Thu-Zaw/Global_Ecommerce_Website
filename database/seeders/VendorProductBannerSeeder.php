<?php

namespace Database\Seeders;

use App\Models\VendorProductBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorProductBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorProductBanner::factory()->create(["image"=>"product-banner-1.jpg"]);
        VendorProductBanner::factory()->create(["image"=>"product-banner-2.jpg"]);
        VendorProductBanner::factory()->create(["image"=>"product-banner-3.jpg"]);
        VendorProductBanner::factory()->create(["image"=>"product-banner-4.jpg"]);
        VendorProductBanner::factory()->create(["image"=>"product-banner-5.jpg"]);
        VendorProductBanner::factory()->create(["image"=>"product-banner-6.jpg"]);
    }
}
