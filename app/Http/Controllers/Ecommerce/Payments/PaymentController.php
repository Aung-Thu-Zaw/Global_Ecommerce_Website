<?php

namespace App\Http\Controllers\Ecommerce\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class PaymentController extends Controller
{
    public function payment(Request $request): Response|ResponseFactory
    {
        $totalPrice=$request->total_price;

        $cartItems=$request->cart_items;

        $stripeKey = env('STRIPE_KEY');

        if($request->payment_method==="creditOrDebitCard") {

            return inertia("Ecommerce/Payments/Stripe", compact("stripeKey", "totalPrice", "cartItems"));
        } elseif($request->payment_method==="paypal") {

            return inertia("Ecommerce/Payments/Paypal", compact("totalPrice", "cartItems"));
        }

        return inertia("Ecommerce/Payments/CashOnDelivery", compact("totalPrice", "cartItems"));
    }
}
