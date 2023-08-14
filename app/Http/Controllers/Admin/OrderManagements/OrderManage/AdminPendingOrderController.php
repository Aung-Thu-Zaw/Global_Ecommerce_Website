<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Jobs\Orders\SendConfirmedOrderEmailToCustomer;
use App\Models\DeliveryInformation;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminPendingOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $pendingOrders=Order::search(request("search"))
                            ->where("order_status", "pending")
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/OrderManagements/OrderManage/PendingOrders/Index", compact("pendingOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation=DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/OrderManagements/OrderManage/PendingOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->load(["orderItems.product.shop"]);

        $order->update([
            "order_status" => "confirmed",
            "confirmed_date" => now()->format("Y-m-d")
        ]);

        SendConfirmedOrderEmailToCustomer::dispatch($order);

        return to_route("admin.orders.pending.index", $this->getQueryStringParams($request))->with("success", "Order is confirmed");
    }
}
