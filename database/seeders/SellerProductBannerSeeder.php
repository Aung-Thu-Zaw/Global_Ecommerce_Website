<?php

namespace Database\Seeders;

use App\Models\SellerProductBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerProductBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellerProductBanner::factory()->create(["image"=>"product-banner-1.jpg"]);
        SellerProductBanner::factory()->create(["image"=>"product-banner-2.jpg"]);
        SellerProductBanner::factory()->create(["image"=>"product-banner-3.jpg"]);
        SellerProductBanner::factory()->create(["image"=>"product-banner-4.jpg"]);
        SellerProductBanner::factory()->create(["image"=>"product-banner-5.jpg"]);
        SellerProductBanner::factory()->create(["image"=>"product-banner-6.jpg"]);
    }
}
