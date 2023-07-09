<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Response;
use Inertia\ResponseFactory;

class CancelOrderAndItemController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $allCancelOrders=Order::where("user_id", auth()->id())
                     ->whereNotNull("cancel_reason")
                     ->whereNotNull("cancel_date")
                     ->whereNotNull("cancel_status")
                     ->orderBy("id", "desc")
                     ->get();

        $requestedCancelOrders=Order::where("user_id", auth()->id())
                     ->whereNotNull("cancel_reason")
                     ->whereNotNull("cancel_date")
                     ->where("cancel_status", "requested")
                     ->orderBy("id", "desc")
                     ->get();

        $approvedCancelOrders=Order::where("user_id", auth()->id())
                     ->whereNotNull("cancel_reason")
                     ->whereNotNull("cancel_date")
                     ->where("cancel_status", "approved")
                     ->whereNotNull("return_approved_date")
                     ->orderBy("id", "desc")
                     ->get();




        return inertia("User/CancelOrdersAndItems/Index", compact(
            "allCancelOrders",
            "requestedCancelOrders",
            "approvedCancelOrders"
        ));
    }
}
