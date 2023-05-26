<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminConfirmedOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $confirmedOrders=Order::search(request("search"))
                             ->where("order_status", "confirmed")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/OrderManage/ConfirmedOrders/Index", compact("confirmedOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $confirmedOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $confirmedOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $confirmedOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/OrderManage/ConfirmedOrders/Detail", compact("confirmedOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        Order::findOrFail($id)->update([
            "order_status"=>"processing",
            "processing_date"=>now()->format("Y-m-d")
        ]);

        return to_route("admin.orders.processing.index")->with("success", "Order is processing");
    }
}
