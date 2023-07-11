<?php

namespace Database\Seeders;

use App\Models\SocialTraffic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialTrafficSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialTraffic::create(["social_name"=>"Facebook"]);
        SocialTraffic::create(["social_name"=>"Instagram"]);
        SocialTraffic::create(["social_name"=>"Twitter"]);
        SocialTraffic::create(["social_name"=>"Youtube"]);
        SocialTraffic::create(["social_name"=>"Reddit"]);
        SocialTraffic::create(["social_name"=>"Linked In"]);
        SocialTraffic::create(["social_name"=>"Blog"]);
    }
}
