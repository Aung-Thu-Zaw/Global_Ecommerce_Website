<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Product;
use App\Models\ProductQuestion;
use App\Models\ProductReview;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    public function newProducts(): Response|ResponseFactory
    {
        $newProducts=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                            ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                            ->whereStatus("approved")
                            ->whereBetween('created_at', [now()->subDays(30), now()])
                            ->orderBy("id", "desc")
                            ->paginate(20);

        return inertia("Ecommerce/Products/NewProducts", compact("newProducts"));
    }

    public function featuredProducts(): Response|ResponseFactory
    {
        $featuredProducts=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                 ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                 ->whereStatus("approved")
                                 ->whereFeatured(1)
                                 ->orderBy("id", "desc")
                                 ->paginate(20);

        return inertia("Ecommerce/Products/FeaturedProducts", compact("featuredProducts"));
    }

    public function hotDealProducts(): Response|ResponseFactory
    {
        $hotDealProducts=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                ->whereStatus("approved")
                                ->whereHotDeal(1)
                                ->orderBy("id", "desc")
                                ->paginate(20);

        return inertia("Ecommerce/Products/HotDealProducts", compact("hotDealProducts"));
    }

    public function show(Product $product): Response|ResponseFactory
    {
        $sellerId=$product->shop ? $product->shop->id : null;

        $product->load(["images","brand:id,name","colors","sizes","shop:id,uuid,offical,shop_name,avatar","watchlists","cartItems"]);

        $productsFromShop=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount")
                                 ->with(["shop:id,uuid"])
                                 ->whereSellerId($sellerId)
                                 ->where("id", "!=", $product->id)
                                 ->limit(5)
                                 ->get();

        $relatedProducts=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                ->whereStatus("approved")
                                ->whereCategoryId($product->category_id)
                                ->where('id', '!=', $product->id)
                                ->limit(10)
                                ->get();

        $productQuestions=ProductQuestion::with(["user","productAnswer.user:id,shop_name,avatar","product:id,user_id"])
                                         ->whereProductId($product->id)
                                         ->orderBy("id", "desc")
                                         ->paginate(5);

        $paginateProductReviews=ProductReview::with(["user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                             ->whereProductId($product->id)
                                             ->orderBy("id", "desc")
                                             ->paginate(5);

        $productReviews=ProductReview::whereProductId($product->id)->get();

        $productReviewsAvg=ProductReview::whereProductId($product->id)->avg("rating");

        $conversation=Conversation::with(["messages.user:id,avatar","customer:id,name,avatar,last_activity","seller:id,shop_name,avatar,offical,last_activity"])
                                  ->whereCustomerId(auth()->id())
                                  ->WhereSellerId($product->seller_id)
                                  ->first();

        return inertia("Ecommerce/Products/Detail", compact(
            "product",
            "productsFromShop",
            "relatedProducts",
            "productQuestions",
            "paginateProductReviews",
            "productReviews",
            "productReviewsAvg",
            "conversation"
        ));
    }
}
