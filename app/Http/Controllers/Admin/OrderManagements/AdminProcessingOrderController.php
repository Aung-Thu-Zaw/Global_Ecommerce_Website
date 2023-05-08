<?php

namespace App\Http\Controllers\Admin\OrderManagements;

use App\Http\Controllers\Controller;
use App\Mail\OrderShippedMail;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminProcessingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $processingOrders=Order::search(request("search"))
                             ->where("status", "processing")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ProcessingOrders/Index", compact("processingOrders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $processingOrderDetail=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with("product.shop")->where("order_id", $processingOrderDetail->id)->get();

        return inertia("Admin/OrderManagements/ProcessingOrders/Detail", compact("processingOrderDetail", "deliveryInformation", "orderItems"));
    }

    public function update(int $id): RedirectResponse
    {

        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $id)->first();

        $order->update(["status"=>"shipped"]);

        Mail::to($order->deliveryInformation->email)->send(new OrderShippedMail($order));

        return to_route("admin.orders.shipped.index")->with("success", "Order is shipped");
    }

}
