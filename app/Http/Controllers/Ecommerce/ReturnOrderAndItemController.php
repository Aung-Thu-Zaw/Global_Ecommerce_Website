<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class ReturnOrderAndItemController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $requestedReturnOrders=Order::where("user_id", auth()->user()->id)
                     ->whereNotNull("return_reason")
                     ->whereNotNull("return_date")
                     ->where("return_status", "pending")
                     ->orderBy("id", "desc")
                     ->get();

        $approvedReturnOrders=Order::where("user_id", auth()->user()->id)
                     ->whereNotNull("return_reason")
                     ->whereNotNull("return_date")
                     ->where("return_status", "approved")
                     ->whereNotNull("return_approved_date")
                     ->orderBy("id", "desc")
                     ->get();

        // $returnItems=Order::where("user_id", auth()->user()->id)
        //              ->whereNotNull("return_reason")
        //              ->whereNotNull("return_date")
        //              ->whereNotNull("return_status")
        //              ->orderBy("id", "desc")
        //              ->get();


        return inertia("User/ReturnOrdersAndItems/Index", compact(
            "requestedReturnOrders",
            "approvedReturnOrders"
        ));
    }
}
