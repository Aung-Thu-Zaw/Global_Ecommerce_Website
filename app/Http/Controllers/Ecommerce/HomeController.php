<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CampaignBanner;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductBanner;
use App\Models\SliderBanner;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;

class HomeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $categories=Category::with("children")->limit(8)->get();

        $collections=Collection::with("products:id,collection_id,image")->limit(12)->get();

        $sliderBanners=SliderBanner::where("status", "show")->orderBy("id", "desc")->limit(6)->get();

        $campaignBanner=CampaignBanner::where("status", "show")->first();

        $productBanners=ProductBanner::where("status", "show")->orderBy("id", "desc")->limit(3)->get();

        $newProducts=Product::with(["shop","watchlists","cartItems"])->where("status", "active")->orderBy("id", "desc")->limit(5)->get();

        $hotDealProducts=Product::with(["shop","watchlists","cartItems"])->where([["status", "active"],["hot_deal",1]])->orderBy("id", "desc")->limit(5)->get();

        $featuredProducts=Product::with(["shop","watchlists","cartItems"])->where([["status", "active"],["featured",1]])->orderBy("id", "desc")->limit(5)->get();


        $randomProducts=Product::with(["shop","watchlists","cartItems"])->where("status", "active")->inRandomOrder()->paginate(25);


        return Inertia::render('Ecommerce/Home/Index', compact("categories", "collections", "sliderBanners", "campaignBanner", "productBanners", "newProducts", "featuredProducts", "hotDealProducts", "randomProducts"));
    }


}
