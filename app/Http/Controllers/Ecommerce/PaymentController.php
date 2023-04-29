<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function payment(Request $request): Response|ResponseFactory
    {
        $totalPrice=$request->total_price;

        $cartItems=$request->cart_items;

        $stripeKey = env('STRIPE_KEY');

        return inertia("Ecommerce/Payments/Stripe", compact("stripeKey", "totalPrice", "cartItems"));
    }

    public function processPayment(Request $request): RedirectResponse
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));


        // dd($request->cart_items);
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->total_price,
            'currency' => 'usd',
            'description'=>'',
            'payment_method' =>$request->payment_method_id,
            'confirm' => true,
            'metadata'=>[
                'order_id' => uniqid(),
            ]
            ]);

        $user=auth()->user();



        $charge = Charge::retrieve($paymentIntent->latest_charge);
        $balanceTransactionId = $charge->balance_transaction;



        $order=Order::create([
            "user_id"=>$user->id,
            "delivery_information_id"=>$user->deliveryInformation->id,
            'payment_type'=>$paymentIntent->payment_method_types[0],
            'payment_method'=>$paymentIntent->payment_method,
            'transaction_id'=>$balanceTransactionId,
            'currency'=>$paymentIntent->currency,
            'total_amount'=>$paymentIntent->amount,
            'order_no'=>$paymentIntent->metadata->order_id,
            'invoice_no'=>'GLOBAL E-COMMERCE'.mt_rand(100000000, 999999999),
            'order_date'=>Carbon::now()->format("Y-m-d"),
            'status'=>"pending",
        ]);




        //    'confirmed_date'=>,
        //    'processing_date'=>,
        //    'picked_date'=>,
        //    'shipped_date'=>,
        //    'delivered_date'=>,
        //    'cancel_date'=>,
        //    'return_date'=>,
        //    'return_reason'=>,




        foreach ($request->cart_items as $item) {
            OrderItem::create([
                "order_id"=>$order->id,
                "product_id"=>$item["product"]["id"],
                "vendor_id"=>$item["product"]["shop"]["id"],
                "color"=>$item["color"] ?? null,
                "size"=>$item["size"] ?? null,
                "qty"=>$item["qty"],
                "price"=>$item["total_price"],
            ]);
        }




        return to_route("home")->with("success", $paymentIntent);
    }
}
