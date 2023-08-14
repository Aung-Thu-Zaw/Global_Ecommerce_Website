<?php

namespace App\Http\Controllers\Ecommerce\Payments;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class CashOnDeliveryController extends Controller
{
    public function cashPaymentProcess(Request $request): RedirectResponse
    {
        $user=User::findOrFail(auth()->id());

        $order=Order::create([
            "user_id"=>$user->id,
            "delivery_information_id"=>$user->deliveryInformation ? $user->deliveryInformation->id : null,
            'payment_type'=>"cash on delivery",
            'payment_method'=>"cash on delivery",
            'total_amount'=>$request->total_price,
            'order_no'=>"#".uniqid(),
            'currency'=>"usd",
            'invoice_no'=>'GLOBAL E-COMMERCE'.mt_rand(100000000, 999999999),
            'order_date'=>Carbon::now()->format("Y-m-d"),
            'order_status'=>"pending",
        ]);


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


        $placedOrder=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $order->id)->first();


        Mail::to($placedOrder->deliveryInformation->email)->send(new OrderPlacedMail($placedOrder));

        if (session("coupon")) {
            session()->forget("coupon");
        }

        $cart=Cart::where("user_id", auth()->id())->first();

        if($cart) {

            $cartItems=$cart->cartItems;

            $cartItems->each(function ($item) {

                $item->destroy($item->id);

            });

        }

        return to_route("home")->with("success", "Your place order is successfully");
    }
}
