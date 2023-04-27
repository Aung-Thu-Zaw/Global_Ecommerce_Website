<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function show(): Response|ResponseFactory
    {
        $stripeKey = env('STRIPE_KEY');

        return inertia("Ecommerce/Payments/Stripe", compact("stripeKey"));
    }

    public function processPayment(Request $request): RedirectResponse
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntent = PaymentIntent::create([
            'amount' => 1000,
            'currency' => 'usd',
            'payment_method' => $request->input('payment_method_id'),
            'confirm' => true,
        ]);


        return back()->with("success", $paymentIntent);
    }
}
