<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ShippingController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $cart=auth()->user()->cart;
        $cartItems=$cart->cartItems;

        $shopIds=$cartItems->pluck("shop_id")->unique()->values();
        $shops = User::select("id", "shop_name")->whereIn('id', $shopIds)->get();

        $cartItems->load(["product.shop","product.brand","product.sizes","product.colors"]);

        return inertia("Ecommerce/Shipping/Index", compact("shops", "cartItems"));
    }
}
