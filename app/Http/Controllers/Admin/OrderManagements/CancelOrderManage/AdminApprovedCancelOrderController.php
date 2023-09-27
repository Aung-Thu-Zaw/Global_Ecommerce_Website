<?php

namespace App\Http\Controllers\Admin\OrderManagements\CancelOrderManage;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Traits\HandlesQueryStringParameters;
use Illuminate\Http\Request;

class AdminApprovedCancelOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $approvedCancelOrders = Order::search(request("search"))
                                     ->where("cancel_status", "approved")
                                     ->where("payment_type", "cash on delivery")
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());

        return inertia("Admin/OrderManagements/CancelOrderManage/ApprovedCancelOrders/Index", compact("approvedCancelOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $deliveryInformation = DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems = OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        return inertia("Admin/OrderManagements/CancelOrderManage/ApprovedCancelOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }
}
