<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProductInteractionRequest;
use App\Models\UserProductInteraction;
use Illuminate\Http\RedirectResponse;

class UserProductInteractionController extends Controller
{
    public function store(UserProductInteractionRequest $request): RedirectResponse
    {
        UserProductInteraction::firstOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ], [
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ]);

        return back();
    }
}
