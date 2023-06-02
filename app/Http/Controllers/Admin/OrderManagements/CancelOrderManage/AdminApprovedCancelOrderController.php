<?php

namespace App\Http\Controllers\Admin\OrderManagements\CancelOrderManage;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminApprovedCancelOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $approvedCancelOrders=Order::search(request("search"))
                                   ->where("cancel_status", "approved")
                                   ->where("payment_type", "cash on delivery")
                                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                                   ->paginate(request("per_page", 10))
                                   ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/ApprovedCancelOrders/Index", compact("approvedCancelOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $approvedCancelOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $approvedCancelOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $approvedCancelOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ReturnOrderManage/ApprovedCancelOrders/Detail", compact("paginate", "approvedCancelOrderDetail", "deliveryInformation", "orderItems"));
    }
}
