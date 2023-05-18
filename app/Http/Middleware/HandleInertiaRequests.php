<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\Storage;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'recaptcha_site_key' => config('services.google_recaptcha.site_key'),
            'auth' => [
                'user' => User::with("cart")->where("id", $request->user()->id ?? null)->first(),
            ],
            'parentCategory'=>Category::with("children")->whereNull("parent_id")->get(),
            'vendors'=>User::where([["role","vendor"],["status","active"]])->limit(30)->get(),
            'totalCartItems'=> Cart::with("cartItems")->where("user_id", $request->user()->id ?? null)->first(),
            "conversations"=>Conversation::with(["messages.user:id,avatar","customer:id,name,avatar","vendor:id,shop_name,avatar"])
                                         ->where("customer_id", auth()->user() ? auth()->user()->id : null)
                                         ->orWhere("vendor_id", auth()->user() ? auth()->user()->id : null)
                                         ->get(),
            'flash'=>[
                'successMessage'=>session('success'),
                'errorMessage'=>session('error'),
                'infoMessage'=>session('info'),

            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                    'query'=>$request->query()
                ]);
            },
        ]);
    }
}
