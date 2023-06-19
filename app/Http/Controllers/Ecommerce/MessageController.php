<?php

namespace App\Http\Controllers\Ecommerce;

use App\Actions\CreateMessageAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    public function store(MessageRequest $request): RedirectResponse
    {
        (new CreateMessageAction())->handle($request);

        return back();
    }

}
