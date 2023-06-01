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
            SeoSettingSeeder::class,
            SliderBannerSeeder::class,
            CampaignBannerSeeder::class,
            ProductBannerSeeder::class,
            UserSeeder::class,
            CouponSeeder::class,
            BrandSeeder::class,







            CategorySeeder::class,
            CollectionSeeder::class,
            ProductSeeder::class,
            ImageSeeder::class,
            CountrySeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            TownshipSeeder::class,
            ]
        );
    }
}
