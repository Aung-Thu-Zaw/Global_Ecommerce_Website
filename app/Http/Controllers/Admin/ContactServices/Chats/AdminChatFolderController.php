<?php

namespace App\Http\Controllers\Admin\ContactServices\Chats;

use App\Http\Controllers\Controller;
use App\Models\ChatFolder;
use App\Rules\RecaptchaRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminChatFolderController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "name" => ["required","string"],
            "captcha_token" => ["required",new RecaptchaRule()],
        ]);

        ChatFolder::create([
            "name" => $request->name,
            "agent_id" => auth()->id()
        ]);

        return back();
    }
}
