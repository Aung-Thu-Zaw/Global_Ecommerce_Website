<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrCancelOrderRequest;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response as HttpResponse;

class MyOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $orders=Order::where("user_id", auth()->user()->id)
                     ->whereNull("return_reason")
                     ->whereNull("return_date")
                     ->whereNull("return_status")
                     ->whereNull("cancel_reason")
                     ->whereNull("cancel_date")
                     ->whereNull("cancel_status")
                     ->orderBy("id", "desc")
                     ->get();

        $toPayOrders=Order::where("user_id", auth()->user()->id)
                          ->where("payment_type", "cash on delivery")
                          ->whereNull("return_reason")
                          ->whereNull("return_date")
                          ->whereNull("return_status")
                          ->whereNull("cancel_reason")
                          ->whereNull("cancel_date")
                          ->whereNull("cancel_status")
                          ->orderBy("id", "desc")
                          ->get();

        $toReceiveOrders=Order::where("user_id", auth()->user()->id)
                                ->where(function ($query) {
                                    $query->where("order_status", "confirmed")
                                          ->orWhere("order_status", "shipped");
                                })
                                ->whereNull("return_reason")
                                ->whereNull("return_date")
                                ->whereNull("return_status")
                                ->whereNull("cancel_reason")
                                ->whereNull("cancel_date")
                                ->whereNull("cancel_status")
                                ->orderBy("id", "desc")
                                ->get();

        $receivedOrders=Order::where("user_id", auth()->user()->id)
                             ->where("order_status", "delivered")
                             ->whereNull("return_reason")
                             ->whereNull("return_date")
                             ->whereNull("return_status")
                             ->whereNull("cancel_reason")
                             ->whereNull("cancel_date")
                             ->whereNull("cancel_status")
                             ->orderBy("id", "desc")
                             ->get();

        return inertia("User/MyOrders/Index", compact(
            "orders",
            "toPayOrders",
            "toReceiveOrders",
            "receivedOrders"
        ));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $order=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", $order->user_id)->first();

        $orderItems=OrderItem::with(["product.shop","product.brand"])
                             ->where("order_id", $order->id)
                             ->get();

        $shopIds=$orderItems->pluck("vendor_id")
                            ->unique()
                            ->values();

        $shops = User::select("id", "shop_name")
                     ->whereIn('id', $shopIds)
                     ->get();

        return inertia("User/MyOrders/Detail", compact(
            "order",
            "orderItems",
            "deliveryInformation",
            "shops"
        ));
    }

    public function return(ReturnOrCancelOrderRequest $request, int $order_id): RedirectResponse
    {
        $order=Order::find($order_id);

        $order->update([
            "return_date"=>now()->format("Y-m-d"),
            "return_reason"=>$request->return_reason,
            "return_status"=>"requested",
        ]);

        $order->orderItems()->each(function ($orderItem) use ($request) {
            $orderItem->update([
                    "return_date"=>now()->format("Y-m-d"),
                    "return_reason"=>$request->return_reason,
                    "return_status"=>"requested",
                ]);
        });

        return to_route("return-orders.index", "tab=all-return-orders")->with("success", "Return request successfully.");
    }

    public function cancel(ReturnOrCancelOrderRequest $request, int $order_id): RedirectResponse
    {
        $order=Order::find($order_id);

        $order->update([
            "cancel_date"=>now()->format("Y-m-d"),
            "cancel_reason"=>$request->cancel_reason,
            "cancel_status"=>"requested",
        ]);

        $order->orderItems()->each(function ($orderItem) use ($request) {
            $orderItem->update([
                    "cancel_date"=>now()->format("Y-m-d"),
                    "cancel_reason"=>$request->cancel_reason,
                    "cancel_status"=>"requested",
                ]);
        });

        return to_route("cancel-orders.index", "tab=all-cancel-orders")->with("success", "Cancel request successfully.");
    }

    public function downloadInvoice(int $order_id): HttpResponse
    {
        $order=Order::find($order_id);

        $pdf = PDF::loadView('files.invoice', compact("order"))->setPaper('a4');

        return response($pdf->output())
               ->header('Content-Type', 'application/pdf')
               ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }
}
