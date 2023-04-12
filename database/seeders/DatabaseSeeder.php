<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
            UserSeeder::class,
            SliderBannerSeeder::class,
            CampaignBannerSeeder::class,
            ProductBannerSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            CollectionSeeder::class,
            ProductSeeder::class,
            ImageSeeder::class,
            ]
        );
    }
}
