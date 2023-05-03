<?php

namespace App\Http\Controllers\Admin\OrderManagements;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminPendingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $pendingOrders=Order::search(request("search"))
                             ->where("status", "pending")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/PendingOrders/Index", compact("pendingOrders"));
    }
}
