<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Mail\OrderShippedMail;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminProcessingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $processingOrders=Order::search(request("search"))
                             ->where("status", "processing")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ProcessingOrders/Index", compact("processingOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $processingOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $processingOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ProcessingOrders/Detail", compact("processingOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {

        $orderItems=OrderItem::where("order_id", $id)->get();

        $orderItems->each(function ($orderItem) {
            $product=Product::where("id", $orderItem->product_id)->first();
            $product->update(["qty"=>$product->qty - $orderItem->qty]);
        });

        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $id)->first();

        $order->update([
            "order_status"=>"shipped",
            "shipped_date"=>now()->format("Y-m-d")
    ]);

        Mail::to($order->deliveryInformation->email)->send(new OrderShippedMail($order));

        return to_route("admin.orders.shipped.index")->with("success", "Order is shipped");
    }

}
