<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminConfirmedOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $confirmedOrders = Order::search(request("search"))
                                ->where("order_status", "confirmed")
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/OrderManagements/OrderManage/ConfirmedOrders/Index", compact("confirmedOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation = DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems = OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/OrderManagements/OrderManage/ConfirmedOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update([
            "order_status" => "processing",
            "processing_date" => now()->format("Y-m-d")
        ]);

        return to_route("admin.orders.confirmed.index", $this->getQueryStringParams($request))->with("success", "Order is processing");
    }
}
