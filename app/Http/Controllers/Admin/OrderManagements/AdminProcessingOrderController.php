<?php

namespace App\Http\Controllers\Admin\OrderManagements;

use App\Http\Controllers\Controller;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminProcessingOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $processingOrders=Order::search(request("search"))
                             ->where("status", "processing")
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Admin/OrderManagements/ProcessingOrders/Index", compact("processingOrders"));
    }

}
