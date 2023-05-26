<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Mail\OrderDeliveredMail;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminShippedOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $shippedOrders=Order::search(request("search"))
                             ->where("order_status", "shipped")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());


        return inertia("Admin/OrderManagements/OrderManage/ShippedOrders/Index", compact("shippedOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $shippedOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $shippedOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $shippedOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/OrderManage/ShippedOrders/Detail", compact("shippedOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $id)->first();

        $order->update([
            "order_status"=>"delivered",
            "delivered_date"=>now()->format("Y-m-d")
        ]);

        Mail::to($order->deliveryInformation->email)->send(new OrderDeliveredMail($order));

        return to_route("admin.orders.delivered.index")->with("success", "Order is delivered");
    }
}
