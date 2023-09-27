<?php

namespace App\Http\Controllers\Admin\OrderManagements\CancelOrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Traits\HandlesQueryStringParameters;
use Illuminate\Http\Request;

class AdminRequestedCancelOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $requestedCancelOrders = Order::search(request("search"))
                                      ->where("cancel_status", "requested")
                                      ->where("payment_type", "cash on delivery")
                                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                                      ->paginate(request("per_page", 10))
                                      ->appends(request()->all());

        return inertia("Admin/OrderManagements/CancelOrderManage/RequestedCancelOrders/Index", compact("requestedCancelOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $deliveryInformation = DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems = OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        return inertia("Admin/OrderManagements/CancelOrderManage/RequestedCancelOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

    public function update(Order $order): RedirectResponse
    {
        $order->load(["deliveryInformation","orderItems.product.shop"]);

        $order->update([
            "cancel_status" => "approved",
            "cancel_approved_date" => now()->format("Y-m-d")
        ]);

        $order->orderItems()->each(function ($orderItem) {
            $orderItem->update([
                "cancel_status" => "approved",
                "cancel_approved_date" => now()->format("Y-m-d")
                ]);
        });

        return to_route("admin.cancel-orders.approved.index")->with("success", "Order cancel is approved.");
    }
}
