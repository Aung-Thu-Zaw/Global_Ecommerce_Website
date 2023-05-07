<?php

namespace App\Http\Controllers\Ecommerce\Payments;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    public function stripePaymentProcess(Request $request): RedirectResponse
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));


        $paymentIntent = PaymentIntent::create([
            'amount' => $request->total_price*100,
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
            'total_amount'=>$request->total_price,
            'order_no'=>$paymentIntent->metadata['order_id'],
            'invoice_no'=>'GLOBAL E-COMMERCE'.mt_rand(100000000, 999999999),
            'order_date'=>Carbon::now()->format("Y-m-d"),
            'status'=>"pending",
        ]);



        $confirmOrder=Order::with("deliveryInformation")->where("id", $order->id)->first();


        // Mail::to($confirmOrder->deliveryInformation->email)->send(new OrderMail($confirmOrder));


        // Mail::to($confirmOrder->deliveryInformation->email)->send(new OrderMail([
        //     "invoice_no"=>$confirmOrder->id,
        //     "amount"=>$confirmOrder->total_amount,
        //     "name"=>$confirmOrder->deliveryInformation->name,
        //     "email"=>$confirmOrder->deliveryInformation->email,
        //     "phone"=>$confirmOrder->deliveryInformation->phone,
        //     "address"=>$confirmOrder->deliveryInformation->address,
        // ]));



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

        if (session("coupon")) {
            session()->forget("coupon");
        }

        $cart=auth()->user()->cart;
        $cartItems=$cart->cartItems;

        $cartItems->each(function ($item) {
            $item->destroy($item->id);
        });




        return to_route("home")->with("success", "Your place order is successfully");
    }
}
