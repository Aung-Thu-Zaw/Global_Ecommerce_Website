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
        SliderBanner::factory()->create(["image"=>"slider-1.jpg","status"=>"show"]);
        SliderBanner::factory()->create(["image"=>"slider-2.jpg","status"=>"show"]);
        SliderBanner::factory()->create(["image"=>"slider-3.jpg","status"=>"show"]);
        SliderBanner::factory()->create(["image"=>"slider-4.jpg","status"=>"show"]);
        SliderBanner::factory()->create(["image"=>"slider-5.jpg","status"=>"show"]);
        SliderBanner::factory()->create(["image"=>"slider-6.jpg","status"=>"show"]);
    }
}
