<?php

namespace Database\Seeders;

use App\Models\CampaignBanner;
use Illuminate\Database\Seeder;

class CampaignBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CampaignBanner::factory()->create(["image"=>"campaign-banner-1.jpg"]);
    }
}
