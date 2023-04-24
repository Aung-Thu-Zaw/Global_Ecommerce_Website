<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;

class CartController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $cart=auth()->user()->cart;
        $cartItems=$cart->cartItems;

        $shopIds=$cartItems->pluck("shop_id")->unique()->values();
        $shops = User::select("id", "shop_name")->whereIn('id', $shopIds)->get();

        $cartItems->load(["product.shop","product.brand","product.sizes","product.colors"]);

        $coupon=session("coupon") ?? "";


        return inertia("Ecommerce/Cart/Index", compact("shops", "cartItems", "coupon"));
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        $coupon = Coupon::where('code', $request->code)
                        ->where('start_date', '<=', now())
                        ->where('end_date', '>=', now())
                        ->first();



        if (!$coupon) {
            return back()->with("error", 'Coupon code is invalid.');
        }

        $usedCount = $coupon->users()->wherePivotNotNull('used_at')->count();


        if($usedCount >= $coupon->max_uses) {
            return back()->with("error", 'Full');
        }

        $isUsed = $user->coupons()->wherePivot('coupon_id', $coupon->id)->whereNotNull('used_at')->exists();

        if($isUsed) {
            return back()->with("error", "You've already used this coupon.");
        }

        if ($coupon->min_spend && $request->total_price < $coupon->min_spend) {
            return back()->with("error", 'Coupon code is not valid for this amount.');
        }

        if ($user) {
            $user->coupons()->attach($coupon->id, ['used_at' => now()]);
        }


        session()->put('coupon', $coupon);

        return back()->with("success", "Coupon code is applied.");
    }



    public function removeCoupon(): RedirectResponse
    {
        session()->forget("coupon");

        // $coupon->update(["uses_count"=>$coupon->uses_count--]);

        return back()->with("success", "Coupon code is removed");
    }
}
