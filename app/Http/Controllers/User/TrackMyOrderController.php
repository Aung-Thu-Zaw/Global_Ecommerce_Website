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
            return back()->with("error", "ORDER_CODE_IS_INVALID");
        }

        return to_route("my-orders.show", $order->id);
    }
}
