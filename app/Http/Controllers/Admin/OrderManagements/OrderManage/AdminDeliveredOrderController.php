<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminDeliveredOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $deliveredOrders=Order::search(request("search"))
                             ->where("status", "delivered")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());


        return inertia("Admin/OrderManagements/DeliveredOrders/Index", compact("deliveredOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $deliveredOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $deliveredOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/DeliveredOrders/Detail", compact("deliveredOrderDetail", "deliveryInformation", "orderItems"));
    }
}
