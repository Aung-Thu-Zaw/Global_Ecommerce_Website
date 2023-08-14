<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Response;
use Inertia\ResponseFactory;

class ReturnOrderAndItemController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $allReturnOrders=Order::where("user_id", auth()->id())
                              ->whereNotNull("return_reason")
                              ->whereNotNull("return_date")
                              ->whereNotNull("return_status")
                              ->orderBy("id", "desc")
                              ->get();

        $requestedReturnOrders=Order::where("user_id", auth()->id())
                                    ->whereNotNull("return_reason")
                                    ->whereNotNull("return_date")
                                    ->whereReturnStatus("requested")
                                    ->orderBy("id", "desc")
                                    ->get();

        $approvedReturnOrders=Order::where("user_id", auth()->id())
                                   ->whereNotNull("return_reason")
                                   ->whereNotNull("return_date")
                                   ->whereNotNull("return_approved_date")
                                   ->whereReturnStatus("approved")
                                   ->orderBy("id", "desc")
                                   ->get();

        $refundedReturnOrders=Order::where("user_id", auth()->id())
                                   ->whereNotNull("return_reason")
                                   ->whereNotNull("return_date")
                                   ->whereNotNull("return_refunded_date")
                                   ->whereReturnStatus("refunded")
                                   ->orderBy("id", "desc")
                                   ->get();

        return inertia("User/ReturnOrdersAndItems/Index", compact(
            "allReturnOrders",
            "requestedReturnOrders",
            "approvedReturnOrders",
            "refundedReturnOrders"
        ));
    }
}
