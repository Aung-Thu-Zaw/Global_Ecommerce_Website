<?php

namespace App\Services\Products;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class UpdateProductQuantityService
{
    public function updateQuantity(Order $order)
    {
        $orderItems=OrderItem::where("order_id", $order->id)->get();

        $orderItems->each(function ($orderItem) {

            $product=Product::findOrFail($orderItem->product_id);

            $product->update(["qty"=>$product->qty - $orderItem->qty]);

        });
    }
}
