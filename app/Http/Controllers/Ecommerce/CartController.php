<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        $cartItems->load(["product.brand","product.sizes","product.colors"]);


        return inertia("Ecommerce/Cart/Index", compact("shops", "cartItems"));
    }
}
