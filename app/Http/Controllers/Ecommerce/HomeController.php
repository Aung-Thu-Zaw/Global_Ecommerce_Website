<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\CampaignBanner;
use App\Models\Product;
use App\Models\ProductBanner;
use App\Models\SliderBanner;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

        $randomProducts=Product::inRandomOrder()->take(35)->get();

        return Inertia::render('Ecommerce/Home/Index', compact("sliderBanners", "campaignBanner", "productBanners", "randomProducts"));
    }
}
