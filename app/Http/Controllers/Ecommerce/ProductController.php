<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    public function newProducts(): Response|ResponseFactory
    {
        $newProducts= Product::select("image", "name", "slug", "price", "discount")
                             ->where("status", "active")
                             ->whereBetween('created_at', [now()->subDays(30), now()])
                             ->orderBy("id", "desc")
                             ->paginate(20);

        return inertia("Ecommerce/Products/NewProducts", compact("newProducts"));
    }

    public function featuredProducts(): Response|ResponseFactory
    {
        $featuredProducts=Product::select("image", "name", "slug", "price", "discount")
                                 ->where([["status", "active"],["featured",1]])
                                 ->orderBy("id", "desc")
                                 ->paginate(20);

        return inertia("Ecommerce/Products/FeaturedProducts", compact("featuredProducts"));
    }

    public function specialOfferProducts(): Response|ResponseFactory
    {
        $specialOfferProducts=Product::select("image", "name", "slug", "price", "discount")
                                     ->where([["status", "active"],["special_offer",1]])
                                     ->orderBy("id", "desc")
                                     ->paginate(20);

        return inertia("Ecommerce/Products/SpecialOfferProducts", compact("specialOfferProducts"));
    }

    public function hotDealProducts(): Response|ResponseFactory
    {
        $hotDealProducts=Product::select("image", "name", "slug", "price", "discount")
                                ->where([["status", "active"],["hot_deal",1]])
                                ->orderBy("id", "desc")
                                ->paginate(20);

        return inertia("Ecommerce/Products/HotDealProducts", compact("hotDealProducts"));
    }

    public function show(Product $product): Response|ResponseFactory
    {
        $product->load(["images","brand:id,name","colors","sizes","shop:id,shop_name","watchlists","cartItems","productQuestions.user","productQuestions.productAnswer.user:id,shop_name,avatar"]);

        $specificShopProducts=Product::select("image", "name", "slug", "price", "discount")
                                     ->where("user_id", $product->shop->id)
                                     ->limit(5)
                                     ->get();

        return inertia("Ecommerce/Products/Detail", compact("product", "specificShopProducts"));
    }
}
