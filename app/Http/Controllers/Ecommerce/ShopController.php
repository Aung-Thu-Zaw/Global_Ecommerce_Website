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
use App\Notifications\FollowedShopNotification;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class ShopController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        $vendorShops=User::search(request("search_shop"))
                         ->where("status", "active")
                         ->where("role", "vendor")
                         ->paginate(30);

        return inertia("Ecommerce/Shops/Index", compact("vendorShops"));
    }

    public function show(string $shopUUID): Response|ResponseFactory
    {
        $user=auth()->user();

        $followings=$user->followings;

        $followers=$user->followers;

        $shop=User::whereUuid($shopUUID)
                  ->whereStatus("active")
                  ->first();

        $vendorProductBanners=VendorProductBanner::select("id", "user_id", "image", "url")
                                                 ->whereUserId($shop->id)
                                                 ->whereStatus("show")
                                                 ->orderBy("id", "desc")
                                                 ->get();

        $vendorRandomProducts=Product::select("id", "user_id", "image", "name", "slug", "price", "discount", "special_offer")
                                     ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                     ->whereUserId($shop->id)
                                     ->whereStatus("active")
                                     ->inRandomOrder()
                                     ->limit(20)
                                     ->get();

        $vendorProducts=Product::select("id", "user_id", "image", "name", "slug", "price", "discount", "special_offer")
                               ->with(["productReviews:id,product_id,rating","shop:id,offical","images"])
                               ->filterBy(request(["search","category","brand","rating","price"]))
                               ->where("status", "active")
                               ->where("user_id", $shop->id)
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(20)
                               ->appends(request()->all());


        $paginateProductReviews=ProductReview::with(["product.sizes","product.colors","product.brand","user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                             ->where("vendor_id", $shop->id)
                                             ->orderBy("id", "desc")
                                             ->paginate(5);

        $productReviews=ProductReview::where("vendor_id", $shop->id)->get();

        $productReviewsAvg=ProductReview::where("vendor_id", $shop->id)->avg("rating");

        $paginateShopReviews=ShopReview::with(["user:id,name,avatar","reply.user:id,shop_name,avatar"])
                                       ->where("vendor_id", $shop->id)
                                       ->orderBy("id", "desc")
                                       ->paginate(5);

        $shopReviews=ShopReview::where("vendor_id", $shop->id)->get();

        $shopReviewsAvg=ShopReview::where("vendor_id", $shop->id)->avg("rating");

        $categories =  Category::join('products', 'categories.id', '=', 'products.category_id')
                               ->join('users', 'products.user_id', '=', 'users.id')
                               ->where('users.id', $shop->id)
                               ->distinct()
                               ->select('categories.*')
                               ->get();

        $brands =  Brand::join('products', 'brands.id', '=', 'products.brand_id')
                               ->join('users', 'products.user_id', '=', 'users.id')
                               ->where('users.id', $shop->id)
                               ->distinct()
                               ->select('brands.*')
                               ->get();

        return inertia("Ecommerce/Shops/Show", compact(
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
        $shop=User::find($shopId);

        $user=auth()->user();

        $user->follow($shop);

        $shop->notify(new FollowedShopNotification($user));

        return back();
    }

    public function unfollowShop(int $shopId): RedirectResponse
    {
        $shop=User::find($shopId);

        auth()->user()->unfollow($shop);

        return back();
    }
}
