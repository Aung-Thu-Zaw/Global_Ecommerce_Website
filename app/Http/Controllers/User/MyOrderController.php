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
        $orders=Order::where("user_id", auth()->user()->id)->orderBy("id", "desc")->get();

        return inertia("User/MyOrders/Index", compact("orders"));
    }

    public function show(int $id): Response|ResponseFactory
    {
        $order=Order::findOrFail($id);

        $deliveryInformation=DeliveryInformation::where("user_id", auth()->user()->id)->first();

        $orderItems=OrderItem::with(["product.shop","product.brand"])->where("order_id", $order->id)->get();

        $shopIds=$orderItems->pluck("vendor_id")->unique()->values();

        $shops = User::select("id", "shop_name")->whereIn('id', $shopIds)->get();

        return inertia("User/MyOrders/Detail", compact("order", "orderItems", "deliveryInformation", "shops"));
    }

    public function downloadInvoice(int $order_id): HttpResponse
    {
        $order=Order::where("id", $order_id)->where("user_id", auth()->user()->id)->first();

        // $pdf = PDF::loadView('files.invoice', compact("order"))->setPaper('a4')->setOption(['tempDir' => public_path(), 'chroot' => public_path()]);
        $pdf = PDF::loadView('files.invoice', compact("order"))->setPaper('a4');

        return response($pdf->output())
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
    }
}
