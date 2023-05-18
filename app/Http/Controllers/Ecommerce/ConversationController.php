<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function store(ConversationRequest $request): RedirectResponse
    {

        Conversation::firstOrCreate([
            "customer_id"=>$request->customer_id,
            "vendor_id"=>$request->vendor_id
        ], [
            "customer_id"=>$request->customer_id,
            "vendor_id"=>$request->vendor_id
        ]);


        return back();
    }
}
