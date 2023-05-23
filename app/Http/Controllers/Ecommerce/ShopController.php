<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ShopReview;
use App\Models\VendorProductBanner;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


        $vendorProducts=Product::with(["shop","watchlists","cartItems"])
                         ->filterBy(request(["search","category","brand","rating","price"]))
                         ->where("status", "active")
                         ->where("user_id", $shopId)
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(20)
                         ->appends(request()->all());


        $paginateProductReviews=ProductReview::with(["product.sizes","product.colors","product.brand","user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                     ->where("vendor_id", $shopId)
                                     ->orderBy("id", "desc")
                                     ->paginate(5);

        $productReviews=ProductReview::where("vendor_id", $shopId)->get();

        $productReviewsAvg=ProductReview::where("vendor_id", $shopId)->avg("rating");

        $paginateShopReviews=ShopReview::with(["user:id,name,avatar","reply.user:id,shop_name,avatar"])
                                     ->where("vendor_id", $shopId)
                                     ->orderBy("id", "desc")
                                     ->paginate(5);

        $shopReviews=ShopReview::where("vendor_id", $shopId)->get();

        $shopReviewsAvg=ShopReview::where("vendor_id", $shopId)->avg("rating");

        $categories =  Category::join('products', 'categories.id', '=', 'products.category_id')
                               ->join('users', 'products.user_id', '=', 'users.id')
                               ->where('users.id', $shopId)
                               ->distinct()
                               ->select('categories.*')
                               ->get();

        $brands =  Brand::join('products', 'brands.id', '=', 'products.brand_id')
                               ->join('users', 'products.user_id', '=', 'users.id')
                               ->where('users.id', $shopId)
                               ->distinct()
                               ->select('brands.*')
                               ->get();


        return inertia("Ecommerce/Shop/Index", compact(
            "shop",
            "followings",
            "followers",
            "vendorProductBanners",
            "vendorRandomProducts",
            "vendorProducts",
            "categories",
            "brands",
            "productReviews",
            "paginateProductReviews",
            "productReviewsAvg",
            "shopReviews",
            "paginateShopReviews",
            "shopReviewsAvg"
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
