<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    public function newProducts(): Response|ResponseFactory
    {
        $newProducts= Product::with(["shop","watchlists"])->where("status", "active")->whereBetween('created_at', [now()->subDays(30), now()])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/NewProducts", compact("newProducts"));
    }

    public function featuredProducts(): Response|ResponseFactory
    {
        $featuredProducts=Product::with(["shop","watchlists"])->where([["status", "active"],["featured",1]])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/FeaturedProducts", compact("featuredProducts"));
    }

    public function specialOfferProducts(): Response|ResponseFactory
    {
        $specialOfferProducts=Product::with(["shop","watchlists"])->where([["status", "active"],["special_offer",1]])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/SpecialOfferProducts", compact("specialOfferProducts"));
    }

    public function hotDealProducts(): Response|ResponseFactory
    {
        $hotDealProducts=Product::with(["shop","watchlists"])->where([["status", "active"],["hot_deal",1]])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/HotDealProducts", compact("hotDealProducts"));
    }

    public function show(Product $product): Response|ResponseFactory
    {
        $product->load(["images","brand","colors","sizes","shop","watchlists"]);

        $specificShopProducts=Product::with(["images","brand","colors","sizes","shop","watchlists"])->where("user_id", $product->shop->id)->limit(5)->get();

        return inertia("Ecommerce/Products/Detail", compact("product", "specificShopProducts"));
    }
}
