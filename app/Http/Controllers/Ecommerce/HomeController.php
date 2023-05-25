<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CampaignBanner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductBanner;
use App\Models\SliderBanner;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $categories=Category::with("children")->limit(8)->get();

        $collections=Collection::select("id", "title", "slug")
                               ->with("products:id,collection_id,image")
                               ->limit(12)
                               ->get();

        $sliderBanners=SliderBanner::select("id", "image", "url")
                                   ->where("status", "show")
                                   ->orderBy("id", "desc")
                                   ->limit(6)
                                   ->get();

        $campaignBanner=CampaignBanner::select("id", "image", "url")
                                      ->where("status", "show")
                                      ->first();

        $productBanners=ProductBanner::select("id", "image", "url")
                                     ->where("status", "show")
                                     ->orderBy("id", "desc")
                                     ->limit(3)
                                     ->get();

        $newProducts=Product::select("id", "image", "name", "slug", "price", "discount")
                               ->with("productReviews:id,product_id,rating")
                            ->where("status", "active")
                            ->orderBy("id", "desc")
                            ->limit(5)
                            ->get();

        $hotDealProducts=Product::select("id", "image", "name", "slug", "price", "discount")
                               ->with("productReviews:id,product_id,rating")
                                ->where([["status", "active"],["hot_deal",1]])
                                ->orderBy("id", "desc")
                                ->limit(5)
                                ->get();

        $featuredProducts=Product::select("id", "image", "name", "slug", "price", "discount")
                               ->with("productReviews:id,product_id,rating")
                                 ->where([["status", "active"],["featured",1]])
                                 ->orderBy("id", "desc")
                                 ->limit(5)
                                 ->get();

        $randomProducts=Product::select("id", "image", "name", "slug", "price", "discount")
                               ->with("productReviews:id,product_id,rating")
                               ->where("status", "active")
                               ->inRandomOrder()
                               ->paginate(25);



        return inertia('Ecommerce/Home/Index', compact(
            "categories",
            "collections",
            "sliderBanners",
            "campaignBanner",
            "productBanners",
            "newProducts",
            "featuredProducts",
            "hotDealProducts",
            "randomProducts"
        ));


    }


}
