<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\CreateDeliveryInformationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use Illuminate\Http\RedirectResponse;

class DeliveryInformationController extends Controller
{
    public function store(DeliveryInformationRequest $request): RedirectResponse
    {
        (new CreateDeliveryInformationAction())->handle($request->validated());

        return back()->with("success", "Saved Your Delivery Information");
    }
}
