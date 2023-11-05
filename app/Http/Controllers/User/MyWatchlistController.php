<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\WatchlistRequest;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProductInteraction;
use App\Models\Watchlist;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class MyWatchlistController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $watchlists = Watchlist::where('user_id', auth()->id())->get();

        $shopIds = $watchlists->pluck('shop_id')->unique()->values();

        $shops = User::select('id', 'shop_name')->whereIn('id', $shopIds)->get();

        $watchlists->load(['product.shop:id,shop_name', 'product.brand:id,name', 'product.sizes', 'product.colors', 'product.types']);

        $mostViewedProducts = UserProductInteraction::where('user_id', auth()->id())
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

        return inertia('User/MyWatchlist/Index', compact('shops', 'watchlists', 'recommendedProducts'));
    }

    public function store(WatchlistRequest $request): RedirectResponse
    {
        $watchlist = Watchlist::where('user_id', $request->user_id)
                              ->where('product_id', $request->product_id)
                              ->where('shop_id', $request->shop_id)
                              ->first();

        if (! $watchlist) {
            Watchlist::create($request->validated());

            return back()->with('success', 'ITEM_IS_MOVED_TO_WATCHLIST');
        }

        $watchlist->delete();

        return back()->with('info', 'ITEM_HAS_BEEN_REMOVED_FROM_YOUR_WATCHLIST');
    }

    public function destroy(Watchlist $watchlist): RedirectResponse
    {
        $watchlist->delete();

        return back()->with('success', 'ITEM_HAS_BEEN_REMOVED_FROM_YOUR_WATCHLIST');
    }
}
