<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class VendorOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $orderItems=OrderItem::search(request("search"))
                             ->query(function (Builder $builder) {
                                 $builder->with("order");
                             })
                             ->where("vendor_id", auth()->id())
                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                             ->paginate(request("per_page", 10))
                             ->appends(request()->all());

        return inertia("Vendor/Orders/Index", compact("orderItems"));
    }
}
