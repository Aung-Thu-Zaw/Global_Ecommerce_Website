<?php

namespace Database\Seeders;

use App\Models\FaqSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Account Managements
        FaqSubCategory::create([
            "faq_category_id"=>1,
            "name"=>"My Account",
            "slug"=>"my-account"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>1,
            "name"=>"Privacy And Security",
            "slug"=>"privacy-and-security"
        ]);

        // Orders
        FaqSubCategory::create([
            "faq_category_id"=>2,
            "name"=>"Order Placements",
            "slug"=>"order-placements"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>2,
            "name"=>"Order Managements",
            "slug"=>"order-managements"
        ]);

        // Payments
        FaqSubCategory::create([
            "faq_category_id"=>3,
            "name"=>"Payment Methods",
            "slug"=>"payment-methods"
        ]);

        // Shipping And Delivery
        FaqSubCategory::create([
            "faq_category_id"=>4,
            "name"=>"Shipping Journey",
            "slug"=>"shipping-journey"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>4,
            "name"=>"Shop Pickup Points",
            "slug"=>"shop-pickup-points"
        ]);

        // Returns And Refunds
        FaqSubCategory::create([
            "faq_category_id"=>5,
            "name"=>"Return Process",
            "slug"=>"return-process"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>5,
            "name"=>"Refund Process",
            "slug"=>"refund-process"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>5,
            "name"=>"Warranty Policy",
            "slug"=>"warranty-policy"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>5,
            "name"=>"Returns Policy",
            "slug"=>"returns-policy"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>5,
            "name"=>"Refunds Policy",
            "slug"=>"refunds-policy"
        ]);

        // Sell on Global E-commerce
        FaqSubCategory::create([
            "faq_category_id"=>6,
            "name"=>"Become a Seller",
            "slug"=>"become-a-seller"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>6,
            "name"=>"Seller Support",
            "slug"=>"seller-support"
        ]);

        // Shop Categories
        FaqSubCategory::create([
            "faq_category_id"=>7,
            "name"=>"Offical Store",
            "slug"=>"offical-store"
        ]);

        // Promotions
        FaqSubCategory::create([
            "faq_category_id"=>8,
            "name"=>"Thingyan Campaign",
            "slug"=>"thingyan-campaign"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>8,
            "name"=>"Voucher Information",
            "slug"=>"voucher-information"
        ]);

        FaqSubCategory::create([
            "faq_category_id"=>8,
            "name"=>"Sales Campaing",
            "slug"=>"sales-campaign"
        ]);
    }
}
