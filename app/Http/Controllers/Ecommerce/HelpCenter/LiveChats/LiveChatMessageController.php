<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter\LiveChats;

use App\Actions\Ecommerce\LiveChats\CreateLiveChatMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LiveChatMessageRequest;
use Illuminate\Http\Request;

class LiveChatMessageController extends Controller
{
    public function store(LiveChatMessageRequest $request): void
    {
        $message = (new CreateLiveChatMessageAction())->handle($request->validated());

        // if($message) {
        //     event(new ChatMessage($message->load("user:id,avatar")));
        // }
    }
}
