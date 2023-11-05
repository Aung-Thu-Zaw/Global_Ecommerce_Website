<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProductInteraction;
use App\Services\UserShopInteractionService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class FollowedShopController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $user = User::findOrFail(auth()->id());

        $followedShops = $user->followings()->with('followable')->get();

        $followedShopIds = $followedShops->pluck('followable_id')->toArray();

        if ($followedShops->isEmpty()) {
            $mostViewedProducts = UserProductInteraction::where('user_id', $user->id)
                                                        ->groupBy('product_id')
                                                        ->pluck('product_id')
                                                        ->toArray();

            $recommendedProducts = Product::select('id', 'seller_id', 'image', 'name', 'slug', 'price', 'discount', 'special_offer')
                                          ->with(['productReviews:id,product_id,rating', 'shop:id,offical'])
                                          ->where('status', 'approved')
                                          ->whereIn('id', $mostViewedProducts)
                                          ->inRandomOrder()
                                          ->limit(10)
                                          ->get();

            return inertia('User/FollowedShops/Index', compact('followedShops', 'recommendedProducts'));
        } else {
            $justForYouProducts = Product::select('id', 'seller_id', 'image', 'name', 'slug', 'price', 'discount', 'special_offer')
                                         ->with(['productReviews:id,product_id,rating', 'shop:id,offical'])
                                         ->where('status', 'approved')
                                         ->whereIn('seller_id', $followedShopIds)
                                         ->inRandomOrder()
                                         ->limit(15)
                                         ->get();

            return inertia('User/FollowedShops/Index', compact('followedShops', 'justForYouProducts'));
        }
    }

    public function unfollowShop(int $shopId): RedirectResponse
    {
        (new UserShopInteractionService())->unfollow($shopId);

        return back();
    }
}
