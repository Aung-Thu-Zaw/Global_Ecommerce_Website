<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Jobs\Orders\SendShippedOrderEmailToCustomer;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Products\UpdateProductQuantityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminProcessingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $processingOrders=Order::search(request("search"))
                               ->where("order_status", "processing")
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(request("per_page", 10))
                               ->appends(request()->all());

        return inertia("Admin/OrderManagements/OrderManage/ProcessingOrders/Index", compact("processingOrders"));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation=DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $order->id)->get();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/OrderManagements/OrderManage/ProcessingOrders/Detail", compact("queryStringParams", "order", "deliveryInformation", "orderItems"));
    }

    public function update(Request $request, Order $order, UpdateProductQuantityService $updateProductQuantityService): RedirectResponse
    {
        $updateProductQuantityService->updateQuantity($order);

        $order->load(["orderItems.product.shop"]);

        $order->update([
            "order_status"=>"shipped",
            "shipped_date"=>now()->format("Y-m-d")
        ]);

        SendShippedOrderEmailToCustomer::dispatch($order);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.orders.processing.index", $queryStringParams)->with("success", "Order is shipped");
    }
}
