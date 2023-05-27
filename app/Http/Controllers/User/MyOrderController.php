<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrderRequest;
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
                     ->orderBy("id", "desc")
                     ->get();

        $toPayOrders=Order::where("user_id", auth()->user()->id)
                          ->where("payment_type", "cash on delivery")
                          ->whereNull("return_reason")
                          ->whereNull("return_date")
                          ->whereNull("return_status")
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
                                ->orderBy("id", "desc")
                                ->get();

        $receivedOrders=Order::where("user_id", auth()->user()->id)
                             ->where("order_status", "delivered")
                             ->whereNull("return_reason")
                             ->whereNull("return_date")
                             ->whereNull("return_status")
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

    public function return(ReturnOrderRequest $request, int $order_id): RedirectResponse
    {
        $order=Order::find($order_id);

        $order->update([
            "return_date"=>now()->format("Y-m-d"),
            "return_reason"=>$request->return_reason,
            "return_status"=>"pending",
        ]);

        $order->orderItems()->each(function ($orderItem) use ($request) {
            $orderItem->update([
                    "return_date"=>now()->format("Y-m-d"),
                    "return_reason"=>$request->return_reason,
                    "return_status"=>"pending",
                ]);
        });

        return back()->with("success", "Return request successfully.");
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
