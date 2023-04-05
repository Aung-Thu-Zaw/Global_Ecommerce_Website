<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CampaignBanner;
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
        $sliderBanners=SliderBanner::where("status", "show")->orderBy("id", "desc")->limit(6)->get();

        $campaignBanner=CampaignBanner::where("status", "show")->first();

        $productBanners=ProductBanner::where("status", "show")->orderBy("id", "desc")->limit(3)->get();

        $newProducts=Product::where("status", "active")->orderBy("id", "desc")->limit(5)->get();

        $randomProducts=Product::inRandomOrder()->paginate(25);


        return Inertia::render('Ecommerce/Home/Index', compact("sliderBanners", "campaignBanner", "productBanners", "newProducts", "randomProducts"));
    }
}
