<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsiteSetting::create([
          "logo"=>"logo.jpg",
          "favicon"=>"favicon.jpg",
          "phone"=>"09347384374",
          "support_phone"=>"09-555-34334-343",
          "email"=>"globalecommerce@example.com",
          "company_address"=>"Tanitharyi Region, Myeik Township, Parami2 Sapal Road",
          "copyright"=>"2018- 2021 bla bla",
          "youtube"=>"https://www.example.com",
          "facebook"=>"https://www.example.com",
          "twitter"=>"https://www.example.com",
          "instagram"=>"https://www.example.com",
          "reddit"=>"https://www.example.com",
          "linked_in"=>"https://www.example.com",
          "blog"=>"https://www.example.com",
        ]);
    }
}
