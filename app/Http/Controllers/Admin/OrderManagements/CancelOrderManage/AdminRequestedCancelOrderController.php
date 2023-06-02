<?php

namespace App\Http\Controllers\Admin\OrderManagements\CancelOrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRequestedCancelOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $requestedCancelOrders=Order::search(request("search"))
                                  ->where("cancel_status", "requested")
                                  ->where("payment_type", "cash on delivery")
                                  ->orderBy(request("sort", "id"), request("direction", "desc"))
                                  ->paginate(request("per_page", 10))
                                  ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/RequestedCancelOrders/Index", compact("requestedCancelOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $requestedCancelOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $requestedCancelOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $requestedCancelOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ReturnOrderManage/RequestedCancelOrders/Detail", compact("paginate", "requestedCancelOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->findOrFail($id);

        $order->update([
            "cancel_status"=>"approved",
            "cancel_approved_date"=>now()->format("Y-m-d")
        ]);

        $order->orderItems()->each(function ($orderItem) {
            $orderItem->update([
                "cancel_status"=>"approved",
                "cancel_approved_date"=>now()->format("Y-m-d")
                ]);
        });

        // Mail::to($order->deliveryInformation->email)->send(new OrderDeliveredMail($order));

        return to_route("admin.cancel-orders.approved.index")->with("success", "Order cancel is approved.");
    }
}
