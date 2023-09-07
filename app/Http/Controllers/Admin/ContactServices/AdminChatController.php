<?php

namespace App\Http\Controllers\Admin\ContactServices;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminChatController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $liveChats = LiveChat::with(["user:id,name,avatar","agent:id,name,avatar","liveChatMessages.chatFileAttachments","liveChatMessages.user:id,name,avatar","liveChatMessages.agent:id,name,avatar","liveChatMessages.replyToMessage"])
                             ->where("agent_id", auth()->id())
                             ->get();

        $liveChatMessages = LiveChatMessage::with(["chatFileAttachments","user:id,name,avatar","agent:id,name,avatar","replyToMessage"])
        ->orderBy("id", "asc")
        ->get();

        return inertia("Admin/ContactServices/Chats/Index", compact("liveChats", "liveChatMessages"));
    }
}
