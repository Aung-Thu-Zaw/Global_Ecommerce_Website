<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter\LiveChats;

use App\Http\Controllers\Controller;
use App\Models\AgentStatus;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SupportLiveChatServiceController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $liveChat = LiveChat::with(["user:id,name,avatar","agent:id,name,avatar"])
        ->select("id", "user_id", "agent_id")
        ->where("user_id", auth()->id())
        ->first();

        if($liveChat) {
            $liveChatMessages = LiveChatMessage::with("chatFileAttachments")->where("live_chat_id", $liveChat->id)->orderBy("id", "desc")->get();
            return inertia("Ecommerce/HelpCenter/LiveChat/Index", compact("liveChat", "liveChatMessages"));
        }

        return inertia("Ecommerce/HelpCenter/LiveChat/Index", compact("liveChat"));
    }

    public function store(Request $request): RedirectResponse
    {

        $liveChat = LiveChat::firstOrCreate(["user_id" => $request->user_id,"agent_id" => $request->agent_id], ["user_id" => $request->user_id,"agent_id" => $request->agent_id]);

        $availableAgent = AgentStatus::where("online_status", "online")
        ->where("chat_status", "avaliable")
        ->whereColumn('current_chat_count', '<', 'max_chat_capacity')
        ->first();

        if ($availableAgent) {
            $liveChat->update(["agent_id" => $availableAgent->id,"is_active" => true]);
        }

        return to_route("service.live-chat.index");
    }


}
