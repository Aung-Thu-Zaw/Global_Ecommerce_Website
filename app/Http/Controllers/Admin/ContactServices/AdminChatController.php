<?php

namespace App\Http\Controllers\Admin\ContactServices;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminChatController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $liveChats = LiveChat::with([
                                 "user:id,name,avatar",
                                 "agent:id,name,avatar",
                                 "liveChatMessages.chatFileAttachments",
                                 "liveChatMessages.user:id,name,avatar",
                                 "liveChatMessages.agent:id,name,avatar",
                                 "liveChatMessages.replyToMessage"
                                ])
                             ->filterBy(request(["search","tab"]))
                             ->where("agent_id", auth()->id())
                             ->orderBy("pinned", "asc")
                             ->get();


        return inertia("Admin/ContactServices/Chats/Index", compact("liveChats"));
    }


}
