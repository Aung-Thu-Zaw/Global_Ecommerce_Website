<?php

namespace Database\Seeders;

use App\Models\SliderBanner;
use Illuminate\Database\Seeder;

class SliderBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SliderBanner::factory()->create(['image' => 'slider-banner-1.jpg']);
        SliderBanner::factory()->create(['image' => 'slider-banner-2.jpg']);
        SliderBanner::factory()->create(['image' => 'slider-banner-3.jpg']);
        SliderBanner::factory()->create(['image' => 'slider-banner-4.jpg']);
        SliderBanner::factory()->create(['image' => 'slider-banner-5.jpg']);
        SliderBanner::factory()->create(['image' => 'slider-banner-6.jpg']);
    }
}
