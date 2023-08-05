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
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        $vendorShops=User::search(request("search_shop"))
                         ->query(function (Builder $builder) {
                             $builder->with(["followers:id","products:id,user_id"])
                                     ->select("id", "uuid", "shop_name", "avatar");
                         })
                         ->where("status", "active")
                         ->where("role", "vendor")
                         ->paginate(30)
                         ->appends(request()->all());

        return inertia("Ecommerce/Shops/Index", compact("vendorShops"));
    }

    public function show(string $shopUUID): Response|ResponseFactory
    {
        $user=User::findOrFail(auth()->id());

        $shop=User::whereUuid($shopUUID)->whereStatus("active")->first();

        $followings=$user->followings;

        $followers=$user->followers;

        $vendorProductBanners=VendorProductBanner::select("id", "user_id", "image", "url")
                                                 ->whereUserId($shop ? $shop->id : "")
                                                 ->whereStatus("show")
                                                 ->orderBy("id", "desc")
                                                 ->get();

        $vendorRandomProducts=Product::select("id", "user_id", "image", "name", "slug", "price", "discount", "special_offer")
                                     ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                     ->whereUserId($shop ? $shop->id : "")
                                     ->whereStatus("approved")
                                     ->inRandomOrder()
                                     ->limit(20)
                                     ->get();

        $vendorProducts=Product::select("id", "user_id", "image", "name", "description", "slug", "price", "discount", "special_offer")
                               ->with(["productReviews:id,product_id,rating","shop:id,offical","images"])
                               ->filterBy(request(["search","category","brand","rating","price"]))
                               ->whereStatus("approved")
                               ->whereUserId($shop ? $shop->id : "")
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(20)
                               ->withQueryString();

        $paginateProductReviews=ProductReview::with(["product.sizes","product.colors","product.types","product.brand","user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                             ->where("vendor_id", $shop ? $shop->id : "")
                                             ->orderBy("id", "desc")
                                             ->paginate(5);

        $productReviews=ProductReview::where("vendor_id", $shop ? $shop->id : "")->get();

        $productReviewsAvg=ProductReview::where("vendor_id", $shop ? $shop->id : "")->avg("rating");

        $paginateShopReviews=ShopReview::with(["user:id,name,avatar","reply.user:id,shop_name,avatar"])
                                       ->where("vendor_id", $shop ? $shop->id : "")
                                       ->orderBy("id", "desc")
                                       ->paginate(5);

        $shopReviews=ShopReview::where("vendor_id", $shop ? $shop->id : "")->get();

        $shopReviewsAvg=ShopReview::where("vendor_id", $shop ? $shop->id : "")->avg("rating");

        $categories=Category::join('products', 'categories.id', '=', 'products.category_id')
                            ->join('users', 'products.user_id', '=', 'users.id')
                            ->where('users.id', $shop ? $shop->id : "")
                            ->distinct()
                            ->select('categories.*')
                            ->get();

        $brands=Brand::join('products', 'brands.id', '=', 'products.brand_id')
                     ->join('users', 'products.user_id', '=', 'users.id')
                     ->where('users.id', $shop ? $shop->id : "")
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
        $shop=User::findOrFail($shopId);

        $user=User::findOrFail(auth()->id());

        $user->follow($shop);

        $shop->notify(new FollowedShopNotification($user));

        return back();
    }

    public function unfollowShop(int $shopId): RedirectResponse
    {
        $shop=User::findOrFail($shopId);

        $user=User::findOrFail(auth()->id());

        $user->unfollow($shop);

        return back();
    }
}
