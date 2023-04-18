<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;

class CartItemController extends Controller
{
    public function store(CartItemRequest $request): RedirectResponse
    {

        $cart=Cart::firstOrCreate(
            ["user_id"=>auth()->user()->id],
            ["user_id"=>auth()->user()->id]
        );

        $cartItem=CartItem::where("product_id", $request->product_id)->first();

        if($cartItem) {
            $cartItem->update(["qty"=> $cartItem->qty + 1]);
        } else {
            CartItem::create(
                [
                    "cart_id"=>$cart->id,
                    "product_id"=>$request->product_id,
                    "shop_id"=>$request->shop_id,
                    "qty"=>$request->qty,
                ]
            );
        }

        return back()->with("success", "$request->qty item(s) have been added to your cart");
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $cartItem->delete();

        return back()->with("success", "$cartItem->qty item(s) have been removed from your cart");
    }
}
