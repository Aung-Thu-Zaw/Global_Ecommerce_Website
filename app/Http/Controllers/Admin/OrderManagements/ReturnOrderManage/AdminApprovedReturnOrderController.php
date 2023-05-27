<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;

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

    public function update(int $id): RedirectResponse
    {
        $order=Order::with(["deliveryInformation","orderItems.product.shop"])->where("id", $id)->first();

        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $payment =PaymentIntent::retrieve($order->payment_id);


            Refund::create([
                 'payment_intent' => $payment->id,
             ]);

            $order->update([
            "return_status"=>"refunded",
            "return_refunded_date"=>now()->format("Y-m-d")
        ]);

            $order->orderItems()->each(function ($orderItem) {
                $orderItem->update([
                    "return_status"=>"refunded",
                    "return_refunded_date"=>now()->format("Y-m-d")
                    ]);
            });

            // Mail::to($order->deliveryInformation->email)->send(new OrderDeliveredMail($order));
            return to_route("admin.return-orders.refunded.index")->with("success", "Order is refunded.");

        } catch (Exception $e) {
            return back()->with("error", $e->getMessage());
        }
    }

}
