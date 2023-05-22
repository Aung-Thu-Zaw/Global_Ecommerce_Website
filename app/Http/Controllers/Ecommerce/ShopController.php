<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\VendorProductBanner;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ShopController extends Controller
{
    public function show(int $shopId): Response|ResponseFactory
    {
        $shop=User::findOrFail($shopId);

        $user=auth()->user();

        $followings=$user->followings;
        $followers=$user->followers;

        $vendorProductBanners=VendorProductBanner::select("user_id", "image", "url")
                                     ->where([["status", "show"],["user_id",$shopId]])
                                     ->orderBy("id", "desc")
                                     ->get();

        $vendorRandomProducts=Product::select("image", "name", "slug", "price", "discount")
                         ->where([["status", "active"],["user_id",$shopId]])
                         ->inRandomOrder()
                         ->limit(20)
                         ->get();

        $vendorProducts=Product::select("image", "name", "slug", "price", "discount")
                               ->where([["status", "active"],["user_id",$shopId]])
                               ->paginate(20);

        $paginateProductReviews=ProductReview::with(["product.sizes","product.colors","product.brand","user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                     ->where("vendor_id", $shopId)
                                     ->orderBy("id", "desc")
                                     ->paginate(5);

        $productReviews=ProductReview::where("vendor_id", $shopId)->get();

        $productReviewsAvg=ProductReview::where("vendor_id", $shopId)->avg("rating");


        return inertia("Ecommerce/Shop/Index", compact(
            "shop",
            "followings",
            "followers",
            "vendorProductBanners",
            "vendorRandomProducts",
            "vendorProducts",
            "productReviews",
            "paginateProductReviews",
            "productReviewsAvg"
        ));
    }

    public function followShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->follow($shop);

        return back();
    }


    public function unfollowShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->unfollow($shop);

        return back();
    }
}
