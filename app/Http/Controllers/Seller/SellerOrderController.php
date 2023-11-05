<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $orderItems = OrderItem::search(request('search'))
                               ->query(function (Builder $builder) {
                                   $builder->with('order');
                               })
                               ->where('shop_id', auth()->id())
                               ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                               ->paginate(request('per_page', 10))
                               ->appends(request()->all());

        return inertia('Seller/Orders/Index', compact('orderItems'));
    }
}
