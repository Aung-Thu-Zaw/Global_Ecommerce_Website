<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\SellerProductBanner;
use App\Models\ShopReview;
use App\Models\User;
use App\Services\UserShopInteractionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class ShopController extends Controller
{
    public function index(): Response | ResponseFactory
    {
        $sellerShops = User::search(request("search_shop"))
                           ->query(function (Builder $builder) {
                               $builder->with(["followers:id","products:id,seller_id","shopReviews:id,shop_id,rating"])
                                       ->select("id", "uuid", "shop_name", "avatar");
                           })
                           ->where("status", "active")
                           ->where("role", "seller")
                           ->paginate(30)
                           ->appends(request()->all());

        return inertia("Ecommerce/Shops/Index", compact("sellerShops"));
    }

    public function show(string $shopUUID): Response|ResponseFactory
    {
        $user = User::findOrFail(auth()->id());

        $shop = User::whereUuid($shopUUID)->where("status", "active")->first();

        $followings = $user->followings;

        $followers = $user->followers;

        $sellerProductBanners = SellerProductBanner::select("id", "seller_id", "image", "url")
                                                   ->where("seller_id", $shop ? $shop->id : null)
                                                   ->where("status", "show")
                                                   ->orderBy("id", "desc")
                                                   ->get();

        $sellerRandomProducts = Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                                       ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                       ->where("seller_id", $shop ? $shop->id : null)
                                       ->where("status", "approved")
                                       ->inRandomOrder()
                                       ->limit(20)
                                       ->get();

        $sellerProducts = Product::select("id", "seller_id", "image", "name", "description", "slug", "price", "discount", "special_offer")
                                 ->with(["productReviews:id,product_id,rating","shop:id,offical","images"])
                                 ->filterBy(request(["search","category","brand","rating","price"]))
                                 ->where("seller_id", $shop ? $shop->id : null)
                                 ->where("status", "approved")
                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                 ->paginate(20)
                                 ->withQueryString();

        $paginateProductReviews = ProductReview::with(["product.sizes","product.colors","product.types","product.brand","user.orders.orderItems","reply.user:id,shop_name,avatar"])
                                               ->where("shop_id", $shop ? $shop->id : null)
                                               ->where("status", "published")
                                               ->orderBy("id", "desc")
                                               ->paginate(5);

        $productReviews = ProductReview::where("shop_id", $shop ? $shop->id : null)
                                       ->where("status", "published")
                                       ->get();

        $productReviewsAvg = ProductReview::where("shop_id", $shop ? $shop->id : null)
                                          ->where("status", "published")
                                          ->avg("rating");

        $paginateShopReviews = ShopReview::with(["user:id,name,avatar","reply.user:id,shop_name,avatar"])
                                         ->where("shop_id", $shop ? $shop->id : null)
                                         ->where("status", "published")
                                         ->orderBy("id", "desc")
                                         ->paginate(5);

        $shopReviews = ShopReview::where("shop_id", $shop ? $shop->id : null)
                                 ->where("status", "published")
                                 ->get();

        $shopReviewsAvg = ShopReview::where("shop_id", $shop ? $shop->id : null)
                                    ->where("status", "published")
                                    ->avg("rating");

        $categories = Category::join('products', 'categories.id', '=', 'products.category_id')
                              ->join('users', 'products.seller_id', '=', 'users.id')
                              ->where('users.id', $shop ? $shop->id : null)
                              ->distinct()
                              ->select('categories.*')
                              ->get();

        $brands = Brand::join('products', 'brands.id', '=', 'products.brand_id')
                       ->join('users', 'products.seller_id', '=', 'users.id')
                       ->where('users.id', $shop ? $shop->id : null)
                       ->distinct()
                       ->select('brands.*')
                       ->get();

        return inertia("Ecommerce/Shops/Show", compact(
            "shop",
            "followings",
            "followers",
            "sellerProductBanners",
            "sellerRandomProducts",
            "sellerProducts",
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
        (new UserShopInteractionService())->follow($shopId);

        return back();
    }

    public function unfollowShop(int $shopId): RedirectResponse
    {
        (new UserShopInteractionService())->unfollow($shopId);

        return back();
    }
}
