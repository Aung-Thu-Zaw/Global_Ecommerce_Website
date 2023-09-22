<?php

namespace App\Http\Controllers\Ecommerce\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Orders\OrderProcessingService;
use Illuminate\Http\RedirectResponse;

class CashOnDeliveryController extends Controller
{
    public function cashPaymentProcess(Request $request): RedirectResponse
    {
        (new OrderProcessingService())->processCashPayment($request->total_price, $request->cart_items);

        return redirect()->route("home")->with("success", "Your order has been placed successfully");
    }
}
