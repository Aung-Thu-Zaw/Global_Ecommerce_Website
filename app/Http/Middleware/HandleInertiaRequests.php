<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Language;
use App\Models\Message;
use App\Models\SearchHistory;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Jorenvh\Share\ShareFacade;
use Tightenco\Ziggy\Ziggy;
use Jorenvh\Share\Share;

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
                'user' => User::with(["cart","permissions","notifications"])->where("id", $request->user()->id ?? null)->first(),
            ],
            'parentCategory' => Category::with("children")->whereNull("parent_id")->get(),
            'languages' => Language::all(),
            'locale' => session('locale'),
            'searchHistories' => SearchHistory::orderBy("id", "desc")->get(),
            'websiteSetting' => WebsiteSetting::first(),
            'sellers' => User::where([["role","seller"],["status","active"]])->limit(30)->get(),
            'totalCartItems' => Cart::with("cartItems")->where("user_id", $request->user()->id ?? null)->first(),
            'socialShares' => (new Share())
                               ->currentPage("Global E-commerce")
                               ->facebook()
                               ->twitter()
                               ->linkedIn()
                               ->reddit()
                               ->telegram()
                               ->whatsApp()
                               ->getRawLinks(),

            "conversations" => Conversation::with(["messages.user:id,avatar","customer:id,name,avatar,last_activity","vendor:id,shop_name,avatar,offical,last_activity"])
                                         ->where("customer_id", auth()->user() ? auth()->user()->id : null)
                                         ->orWhere("seller_id", auth()->user() ? auth()->user()->id : null)
                                         ->get(),

            'flash' => [
                'successMessage' => session('success'),
                'errorMessage' => session('error'),
                'infoMessage' => session('info'),
                'suggestions' => session('suggestions'),

            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                    'query' => $request->query()
                ]);
            },
        ]);
    }
}
