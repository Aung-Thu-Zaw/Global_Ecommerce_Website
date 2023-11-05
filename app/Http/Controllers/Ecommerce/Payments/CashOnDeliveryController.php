<?php

namespace App\Http\Controllers\Ecommerce\Payments;

use App\Http\Controllers\Controller;
use App\Services\Payments\ProcessPaymentByPlacingOrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CashOnDeliveryController extends Controller
{
    public function cashPaymentProcess(Request $request): RedirectResponse
    {
        (new ProcessPaymentByPlacingOrderService())->processPayment($request->total_price, $request->cart_items, null, 'cash');

        return redirect()->route('home')->with('success', 'Your order has been placed successfully');
    }
}
