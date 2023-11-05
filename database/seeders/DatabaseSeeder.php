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
                PermissionSeeder::class,
                RoleSeeder::class,
                WebsiteSettingSeeder::class,
                SeoSettingSeeder::class,
                UserSeeder::class,
                SliderBannerSeeder::class,
                CampaignBannerSeeder::class,
                ProductBannerSeeder::class,
                CategorySeeder::class,
                BrandSeeder::class,
                CollectionSeeder::class,
                ProductSeeder::class,
                ImageSeeder::class,
                CouponSeeder::class,
                CountrySeeder::class,
                RegionSeeder::class,
                CitySeeder::class,
                TownshipSeeder::class,
                BlogCategorySeeder::class,
                BlogPostSeeder::class,
                BlogCommentSeeder::class,
                BlogCommentReplySeeder::class,
                // ProductReviewSeeder::class,
                // ShopReviewSeeder::class,
                SellerProductBannerSeeder::class,
                LanguageSeeder::class,
                SearchHistorySeeder::class,
                SocialTrafficSeeder::class,
                SellerDashboardGuideSeeder::class,
                PageSeeder::class,
                FaqCategorySeeder::class,
                FaqSubCategorySeeder::class,
                FaqSeeder::class,
                FlashSaleSeeder::class,
            ]
        );
    }
}
