<?php

namespace App\Services\Orders;

use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class OrderProcessingService
{
    public function createOrder(User $user, int $totalPrice, string $paymentId = null, string $paymentType, string $paymentMethod, string $currency = 'usd', string $transactionId = null): Order
    {
        $order = Order::create([
            "user_id" => $user->id,
            "delivery_information_id" => $user->deliveryInformation ? $user->deliveryInformation->id : null,
            'payment_id' => $paymentId,
            'payment_type' => $paymentType,
            'payment_method' => $paymentMethod,
            'total_amount' => $totalPrice,
            'transaction_id' => $transactionId,
            'currency' => $currency,
            'order_no' => "#" . uniqid(),
            'invoice_no' => 'GLOBAL E-COMMERCE' . mt_rand(100000000, 999999999),
            'order_date' => Carbon::now()->format("Y-m-d"),
            'order_status' => "pending",
        ]);

        $order->load(["orderItems.product.shop"]);

        return $order;
    }

    /**
    * @param array<mixed> $cartItems
    */
    public function createOrderItems(int $orderId, array $cartItems): void
    {
        foreach ($cartItems as $item) {
            OrderItem::create([
                "order_id" => $orderId,
                "product_id" => $item["product"]["id"],
                "shop_id" => $item["product"]["shop"]["id"],
                "color" => $item["color"] ?? null,
                "size" => $item["size"] ?? null,
                "qty" => $item["qty"],
                "price" => $item["total_price"],
            ]);
        }
    }

    public function notifyOrderPlacedToAdmins(Order $order): void
    {
        $admins = User::where("role", "admin")->get();
        Notification::send($admins, new OrderPlacedNotification($order));
    }

    public function sendOrderPlacedMail(Order $order): void
    {
        if($order->deliveryInformation) {

            Mail::to($order->deliveryInformation->email)->queue(new OrderPlacedMail($order));

        }
    }

    public function removeCouponSession(): void
    {
        if (session("coupon")) {
            session()->forget("coupon");
        }
    }

    public function clearCartItems(): void
    {
        $cart = Cart::where("user_id", auth()->id())->first();

        if ($cart) {
            $cartItems = $cart->cartItems;

            $cartItems->each(function ($item) {

                $item->destroy($item->id);

            });
        }
    }
}
