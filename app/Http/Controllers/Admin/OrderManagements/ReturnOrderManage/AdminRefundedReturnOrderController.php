<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRefundedReturnOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $refundedReturnOrders=Order::search(request("search"))
                                   ->where("return_status", "refunded")
                                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                                   ->paginate(request("per_page", 10))
                                   ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/RefundedReturnOrders/Index", compact("refundedReturnOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $refundedReturnOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $refundedReturnOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $refundedReturnOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ReturnOrderManage/RefundedReturnOrders/Detail", compact("refundedReturnOrderDetail", "deliveryInformation", "orderItems"));
    }

}
