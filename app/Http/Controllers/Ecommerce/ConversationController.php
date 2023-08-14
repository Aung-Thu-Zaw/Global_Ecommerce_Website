<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

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

    public function markMessageAsSeen(Conversation $conversation): RedirectResponse
    {
        $messages = Message::where('conversation_id', $conversation->id)->where("user_id", "!=", request()->user_id)->get();

        foreach ($messages as $message) {
            $message->update(["is_seen"=>true]);
        }

        return back();
    }
}
