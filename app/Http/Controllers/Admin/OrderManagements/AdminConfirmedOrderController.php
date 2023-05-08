<?php

namespace App\Http\Controllers\Admin\OrderManagements;

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
                             ->where("status", "confirm")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ConfirmedOrders/Index", compact("confirmedOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $confirmedOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $confirmedOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ConfirmedOrders/Detail", compact("confirmedOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        Order::findOrFail($id)->update(["status"=>"procesing"]);

        return back()->with("success", "Order is processing");
    }
}
