<?php

namespace App\Http\Controllers\Admin\ContactServices;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminChatController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $liveChats = LiveChat::with(["user:id,name,avatar","agent:id,name,avatar"])
                             ->where("agent_id", auth()->id())
                             ->get();

        return inertia("Admin/ContactServices/Chats/Index", compact("liveChats"));
    }
}
