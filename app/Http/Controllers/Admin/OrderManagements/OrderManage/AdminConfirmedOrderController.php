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

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation=DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/OrderManagements/OrderManage/ConfirmedOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update([
            "order_status"=>"processing",
            "processing_date"=>now()->format("Y-m-d")
        ]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.orders.confirmed.index", $queryStringParams)->with("success", "Order is processing");
    }
}
