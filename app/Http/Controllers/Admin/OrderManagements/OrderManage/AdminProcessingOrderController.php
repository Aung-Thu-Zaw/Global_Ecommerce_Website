<?php

namespace App\Http\Controllers\Admin\OrderManagements\OrderManage;

use App\Http\Controllers\Controller;
use App\Mail\OrderShippedMail;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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

    public function show(int $id): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $processingOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $processingOrderDetail->user_id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $processingOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/OrderManage/ProcessingOrders/Detail", compact("paginate", "processingOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {
        $orderItems=OrderItem::where("order_id", $id)->get();

        $orderItems->each(function ($orderItem) {
            $product=Product::findOrFail($orderItem->product_id);
            $product->update(["qty"=>$product->qty - $orderItem->qty]);
        });

        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->findOrFail($id);

        $order->update([
            "order_status"=>"shipped",
            "shipped_date"=>now()->format("Y-m-d")
    ]);

        $deliveryInformation = $order->deliveryInformation;

        if ($deliveryInformation) {
            Mail::to($deliveryInformation->email)->send(new OrderShippedMail($order));
        }
        return to_route("admin.orders.shipped.index")->with("success", "Order is shipped");

    }
}
