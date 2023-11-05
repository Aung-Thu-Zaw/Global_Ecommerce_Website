<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function store(CartItemRequest $request): RedirectResponse
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['user_id' => auth()->id()]
        );

        $cartItem = CartItem::whereProductId($request->product_id)
                          ->whereColor($request->color)
                          ->whereSize($request->size)
                          ->first();

        if ($cartItem) {
            $cartItem->update(['qty' => $cartItem->qty + $request->qty]);
        } else {
            CartItem::create($request->validated() + ['cart_id' => $cart->id]);
        }

        return back()->with('success', "$request->qty item(s) have been added to your cart");
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $cartItem->update([
            'qty' => $request->qty,
            'total_price' => $request->total_price,
        ]);

        return back();
    }

    public function destroy(CartItem $cartItem): RedirectResponse
    {
        $cartItem->delete();

        return back()->with('success', "$cartItem->qty item(s) have been removed from your cart");
    }
}
