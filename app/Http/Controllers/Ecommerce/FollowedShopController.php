<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProductInteraction;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class FollowedShopController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $user=auth()->user();

        $followedShops=$user->followings()->with('followable')->get();

        $followedShopIds = $followedShops->pluck('followable_id')->toArray();

        if(!$followedShops) {

            $mostViewedProducts=UserProductInteraction::whereUserId($user->id)
                                                      ->groupBy('product_id')
                                                      ->pluck('product_id')
                                                      ->toArray();

            $recommendedProducts = Product::select("id", "user_id", "image", "name", "slug", "price", "discount", "special_offer")
                                          ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                          ->whereStatus("active")
                                          ->whereIn('id', $mostViewedProducts)
                                          ->inRandomOrder()
                                          ->limit(10)
                                          ->get();

            return inertia("User/FollowedShops/Index", compact("followedShops", "recommendedProducts"));

        } else {

            $justForYouProducts = Product::select("id", "user_id", "image", "name", "slug", "price", "discount", "special_offer")
                                         ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                                         ->whereStatus("active")
                                         ->whereIn("user_id", $followedShopIds)
                                         ->inRandomOrder()
                                         ->limit(15)
                                         ->get();

            return inertia("User/FollowedShops/Index", compact("followedShops", "justForYouProducts"));

        }
    }

    public function unfollowShop(int $shopId): RedirectResponse
    {
        $user=auth()->user();

        $shop=User::find($shopId);

        $user->unfollow($shop);

        return back();
    }
}
