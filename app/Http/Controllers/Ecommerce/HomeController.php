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
        $categories=Category::with('subCategories')->limit(8)->get();

        $collections=Collection::with("products:id,collection_id")->limit(12)->get();

        $sliderBanners=SliderBanner::where("status", "show")->orderBy("id", "desc")->limit(6)->get();

        $campaignBanner=CampaignBanner::where("status", "show")->first();

        $productBanners=ProductBanner::where("status", "show")->orderBy("id", "desc")->limit(3)->get();

        $newProducts=Product::where("status", "active")->orderBy("id", "desc")->limit(5)->get();

        $randomProducts=Product::inRandomOrder()->paginate(25);


        return Inertia::render('Ecommerce/Home/Index', compact("categories", "collections", "sliderBanners", "campaignBanner", "productBanners", "newProducts", "randomProducts"));
    }
}
