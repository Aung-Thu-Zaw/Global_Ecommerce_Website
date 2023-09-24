<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\Ecommerce\CreateDeliveryInformationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryInformationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeliveryInformationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {

        // dd($request->all());
        (new CreateDeliveryInformationAction())->handle($request->all());

        return back()->with("success", "Saved Your Delivery Information");
    }
}
