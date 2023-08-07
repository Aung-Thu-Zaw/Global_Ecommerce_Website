<?php

namespace Database\Seeders;

use App\Models\SellerDashboardGuide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellerDashboardGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SellerDashboardGuide::factory()->create(["title"=>"Dashboard"]);
        SellerDashboardGuide::factory()->create(["title"=>"Products"]);
        SellerDashboardGuide::factory()->create(["title"=>"Product Banners"]);
        SellerDashboardGuide::factory()->create(["title"=>"Orders"]);
        SellerDashboardGuide::factory()->create(["title"=>"Return Orders"]);
        SellerDashboardGuide::factory()->create(["title"=>"Cancel Orders"]);
        SellerDashboardGuide::factory()->create(["title"=>"Product Reviews"]);
        SellerDashboardGuide::factory()->create(["title"=>"Shop Reviews"]);
        SellerDashboardGuide::factory()->create(["title"=>"Support"]);
    }
}
