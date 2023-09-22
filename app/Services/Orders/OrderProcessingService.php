<?php

namespace App\Services\Orders;

use App\Mail\OrderPlacedMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderProcessingService
{
    /**
    * @param array<mixed> $cartItems
    */
    public function processCashPayment(int $totalPrice, array $cartItems)
    {
        $order = $this->createOrder($totalPrice);

        $order->load(["deliveryInformation", "orderItems.product.shop"]);

        $this->createOrderItems($order->id, $cartItems);

        $this->sendOrderPlacedMail($order);

        $this->clearCartItems();

    }

    private function createOrder(int $totalPrice): Order
    {
        $user = User::findOrFail(auth()->id());

        return Order::create([
            "user_id" => $user->id,
            "delivery_information_id" => $user->deliveryInformation ? $user->deliveryInformation->id : null,
            'payment_type' => "cash on delivery",
            'payment_method' => "cash on delivery",
            'total_amount' => $totalPrice,
            'order_no' => "#" . uniqid(),
            'currency' => "usd",
            'invoice_no' => 'GLOBAL E-COMMERCE' . mt_rand(100000000, 999999999),
            'order_date' => Carbon::now()->format("Y-m-d"),
            'order_status' => "pending",
        ]);
    }


    /**
    * @param array<mixed> $cartItems
    */
    private function createOrderItems(int $orderId, array $cartItems): void
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

    private function sendOrderPlacedMail(Order $order): void
    {
        if($order->deliveryInformation) {

            Mail::to($order->deliveryInformation->email)->queue(new OrderPlacedMail($order));

        }
    }

    private function clearCartItems(): void
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
