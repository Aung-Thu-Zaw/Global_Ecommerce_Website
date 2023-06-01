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
        SliderBanner::create(["image"=>"slider-1.jpg","url"=>"https://www.example.com","status"=>"show"]);
        SliderBanner::create(["image"=>"slider-2.jpg","url"=>"https://www.example.com","status"=>"show"]);
        SliderBanner::create(["image"=>"slider-3.jpg","url"=>"https://www.example.com","status"=>"show"]);
        SliderBanner::create(["image"=>"slider-4.jpg","url"=>"https://www.example.com","status"=>"show"]);
        SliderBanner::create(["image"=>"slider-5.jpg","url"=>"https://www.example.com","status"=>"show"]);
        SliderBanner::create(["image"=>"slider-6.jpg","url"=>"https://www.example.com","status"=>"show"]);
    }
}
