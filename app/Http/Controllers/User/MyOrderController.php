<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Response as HttpResponse;

class MyOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $orders=Order::where("user_id", auth()->user()->id)
                     ->orderBy("id", "desc")
                     ->get();

        $toPayOrders=Order::where("user_id", auth()->user()->id)
                          ->where("payment_type", "cash on delivery")
                          ->orderBy("id", "desc")
                          ->get();

        $toReceiveOrders=Order::where("user_id", auth()->user()->id)
                                ->where(function ($query) {
                                    $query->where("status", "confirm")
                                          ->orWhere("status", "shipped");
                                })
                                ->orderBy("id", "desc")
                                ->get();

        $receivedOrders=Order::where("user_id", auth()->user()->id)
                             ->where("status", "delivered")
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

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

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

    public function downloadInvoice(int $order_id): HttpResponse
    {
        $order=Order::where("id", $order_id)
                    ->where("user_id", auth()->user()->id)
                    ->first();

        $pdf = PDF::loadView('files.invoice', compact("order"))->setPaper('a4');

        return response($pdf->output())
               ->header('Content-Type', 'application/pdf')
               ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }
}
