<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminPendingReturnOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $pendingReturnOrders=Order::search(request("search"))
                             ->where("return_status", "pending")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/PendingReturnOrders/Index", compact("pendingReturnOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $pendingReturnOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $pendingReturnOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $pendingReturnOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ReturnOrderManage/PendingReturnOrders/Detail", compact("pendingReturnOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $id)->first();

        $order->update([
            "return_status"=>"approved",
            "return_approved_date"=>now()->format("Y-m-d")
        ]);

        // Mail::to($order->deliveryInformation->email)->send(new OrderDeliveredMail($order));

        return to_route("admin.return-orders.approved.index")->with("success", "Order is approved.");
    }
}
