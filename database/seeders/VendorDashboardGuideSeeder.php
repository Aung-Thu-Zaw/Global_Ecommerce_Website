<?php

namespace Database\Seeders;

use App\Models\VendorDashboardGuide;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorDashboardGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorDashboardGuide::factory()->create(["title"=>"Dashboard"]);
        VendorDashboardGuide::factory()->create(["title"=>"Products"]);
        VendorDashboardGuide::factory()->create(["title"=>"Product Banners"]);
        VendorDashboardGuide::factory()->create(["title"=>"Orders"]);
        VendorDashboardGuide::factory()->create(["title"=>"Return Orders"]);
        VendorDashboardGuide::factory()->create(["title"=>"Cancel Orders"]);
        VendorDashboardGuide::factory()->create(["title"=>"Product Reviews"]);
        VendorDashboardGuide::factory()->create(["title"=>"Shop Reviews"]);
        VendorDashboardGuide::factory()->create(["title"=>"Support"]);
    }
}
