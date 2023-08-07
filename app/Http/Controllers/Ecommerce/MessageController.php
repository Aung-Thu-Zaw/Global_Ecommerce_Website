<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\CreateMessageAction;
use App\Events\ChatMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function store(MessageRequest $request): void
    {
        $message= (new CreateMessageAction())->handle($request);

        if($message) {
            event(new ChatMessage($message->load("user:id,avatar")));
        }
    }

}
