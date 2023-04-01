<?php

namespace Database\Seeders;

use App\Models\SliderBanner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        SliderBanner::factory(10)->create();
        SliderBanner::factory(6)->create(["status"=>"show"]);
    }
}
