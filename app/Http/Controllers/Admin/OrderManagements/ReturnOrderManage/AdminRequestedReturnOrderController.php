<?php

namespace App\Http\Controllers\Admin\OrderManagements\ReturnOrderManage;

use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRequestedReturnOrderController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $requestedReturnOrders = Order::search(request('search'))
                                      ->where('return_status', 'requested')
                                      ->where('payment_type', 'card')
                                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                      ->paginate(request('per_page', 10))
                                      ->appends(request()->all());

        return inertia('Admin/OrderManagements/ReturnOrderManage/RequestedReturnOrders/Index', compact('requestedReturnOrders'));
    }

    public function show(Request $request, Order $order): Response|ResponseFactory
    {
        $deliveryInformation = DeliveryInformation::where('user_id', $order->user_id)->first();

        $orderItems = OrderItem::with('product.shop')->where('order_id', $order->id)->get();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/OrderManagements/ReturnOrderManage/RequestedReturnOrders/Detail', compact('queryStringParams', 'order', 'deliveryInformation', 'orderItems'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->load(['deliveryInformation', 'orderItems.product.shop']);

        $order->update([
            'return_status' => 'approved',
            'return_approved_date' => now()->format('Y-m-d'),
        ]);

        $order->orderItems()->each(function ($orderItem) {
            $orderItem->update([
                'return_status' => 'approved',
                'return_approved_date' => now()->format('Y-m-d'),
            ]);
        });

        // Approved return mail

        return to_route('admin.return-orders.requested.index', $this->getQueryStringParams($request))->with('success', 'Order return is approved.');
    }
}
