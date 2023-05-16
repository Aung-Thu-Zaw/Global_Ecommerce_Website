<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductQuestion;
use App\Models\ProductReview;
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
        $product->load(["images","brand:id,name","colors","sizes","shop:id,shop_name,avatar","watchlists","cartItems"]);

        $specificShopProducts=Product::select("image", "name", "slug", "price", "discount")
                                     ->where("user_id", $product->shop->id)
                                     ->where("id", "!=", $product->id)
                                     ->limit(5)
                                     ->get();


        $productQuestions=ProductQuestion::with(["user","productAnswer.user:id,shop_name,avatar","product:id,user_id"])
                                         ->where("product_id", $product->id)
                                         ->orderBy("id", "desc")
                                         ->paginate(5);


        $productReviews=ProductReview::with(["user:id,avatar"])
                                     ->where("product_id", $product->id)
                                     ->orderBy("id", "desc")
                                     ->paginate(5);

        return inertia("Ecommerce/Products/Detail", compact("product", "specificShopProducts", "productQuestions", "productReviews"));
    }
}
