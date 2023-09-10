<?php

namespace App\Http\Controllers\Admin\ContactServices;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
                             ->orderBy("pinned", "desc")
                             ->get();


        return inertia("Admin/ContactServices/Chats/Index", compact("liveChats"));
    }

    public function show(LiveChat $liveChat): Response|ResponseFactory
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
                             ->orderBy("pinned", "desc")
                             ->get();

        $liveChat->load([
            "user:id,name,avatar",
            "agent:id,name,avatar",
            "liveChatMessages.chatFileAttachments",
            "liveChatMessages.user:id,name,avatar",
            "liveChatMessages.agent:id,name,avatar",
            "liveChatMessages.replyToMessage"
           ]);


        return inertia("Admin/ContactServices/Chats/Show", compact("liveChats", "liveChat"));
    }

    public function pinnedChat(Request $request, LiveChat $liveChat): RedirectResponse
    {
        $liveChat->update([
            "pinned" => $request->pinned,
        ]);

        return back();
    }

}
