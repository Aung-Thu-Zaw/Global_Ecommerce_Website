<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use App\Models\DeliveryInformation;
use Illuminate\Http\RedirectResponse;

class DeliveryInformationController extends Controller
{
    public function store(DeliveryInformationRequest $request): RedirectResponse
    {
        DeliveryInformation::create($request->validated());

        return back()->with("success", "Saved Your Delivery Information");
    }
}
