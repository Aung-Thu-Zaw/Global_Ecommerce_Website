<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TrackMyOrderController extends Controller
{
    public function trackMyOrder(Request $request): RedirectResponse
    {
        $order=Order::where("order_no", $request->order_no)->first();

        if(!$order) {
            return back()->with("error", "Order Code is invalid.");
        }

        return to_route("my-orders.show", $order->id);
    }
}
