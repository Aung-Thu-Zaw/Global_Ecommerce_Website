<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminApprovedReturnOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $approvedReturnOrders=Order::search(request("search"))
                             ->where("return_status", "approved")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/ApprovedReturnOrders/Index", compact("approvedReturnOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $approvedReturnOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $approvedReturnOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $approvedReturnOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ReturnOrderManage/ApprovedReturnOrders/Detail", compact("approvedReturnOrderDetail", "deliveryInformation", "orderItems"));
    }

}
