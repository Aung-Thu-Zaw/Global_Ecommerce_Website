<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminRefundedReturnOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $refundedReturnOrders = Order::search(request("search"))
                                     ->where("return_status", "refunded")
                                     ->where("payment_type", "card")
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());

        return inertia("Admin/OrderManagements/ReturnOrderManage/RefundedReturnOrders/Index", compact("refundedReturnOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation = DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems = OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/OrderManagements/ReturnOrderManage/RefundedReturnOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

}
