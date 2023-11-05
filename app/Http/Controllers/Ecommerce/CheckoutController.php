<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\City;
use App\Models\Country;
use App\Models\DeliveryInformation;
use App\Models\Region;
use App\Models\Township;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;

class CheckoutController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $cart = Cart::where('user_id', auth()->id())->first();

        $cartItems = $cart->cartItems;

        $shopIds = $cartItems->pluck('shop_id')->unique()->values();
        $shops = User::select('id', 'shop_name')->whereIn('id', $shopIds)->get();

        $cartItems->load(['product.shop', 'product.brand', 'product.sizes', 'product.colors', 'product.types']);

        $countries = Country::all();
        $regions = Region::with('country')->get();
        $cities = City::with('region')->get();
        $townships = Township::with('city')->get();

        $deliveryInformation = DeliveryInformation::where('user_id', auth()->id())->first();

        $coupon = session('coupon') ?? '';

        return inertia('Ecommerce/Checkout/Index', compact('shops', 'cartItems', 'countries', 'regions', 'cities', 'townships', 'deliveryInformation', 'coupon'));
    }
}
