<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter\LiveChats;

use App\Events\NewLiveChatAssignment;
use App\Http\Controllers\Controller;
use App\Models\AgentStatus;
use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use App\Services\BroadcastNotifications\NewLiveChatAssignmentNotificationSendToAdminDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Support\Str;

class SupportLiveChatServiceController extends Controller
{
    public function show(string $uuid): Response|ResponseFactory
    {
        $liveChat = LiveChat::with(["user:id,name,avatar","agent:id,name,avatar","liveChatMessages.chatFileAttachments","liveChatMessages.user:id,name,avatar","liveChatMessages.agent:id,name,avatar","liveChatMessages.replyToMessage"])
                                   ->where("user_id", auth()->id())
                                   ->where("uuid", $uuid)
                                   ->where("is_active", true)
                                   ->first();













        return inertia("Ecommerce/HelpCenter/LiveChat/Show", compact("liveChat"));
    }

    public function store(Request $request): RedirectResponse
    {

        $liveChat = LiveChat::firstOrCreate(
            [
                "user_id" => $request->user_id,
                "agent_id" => $request->agent_id,
                "is_active" => true
            ],
            [
                "user_id" => $request->user_id,
                "agent_id" => $request->agent_id,
                "is_active" => true
            ]
        );

        $availableAgent = AgentStatus::where("online_status", "online")
        ->where("chat_status", "avaliable")
        ->whereColumn('current_chat_count', '<', 'max_chat_capacity')
        ->first();

        if ($availableAgent) {
            $liveChat->update(["uuid" => Str::uuid(),"agent_id" => $availableAgent->agent_id,"is_active" => true]);

            $agentStatus = AgentStatus::where("agent_id", $availableAgent->agent_id)->first();

            if($agentStatus) {

                $agentStatus->update([
                    "current_chat_count" => $agentStatus->current_chat_count + 1,
                    "chat_status" => $agentStatus->max_chat_capacity > $agentStatus->current_chat_count + 1 ? "avaliable" : "busy"
            ]);
            }

            $liveChat->load(["user:id,name,avatar","agent:id,name,avatar"]);

            (new NewLiveChatAssignmentNotificationSendToAdminDashboardService())->send($liveChat);

            event(new NewLiveChatAssignment($liveChat));

            return to_route("service.live-chat.show", $liveChat->uuid);
        }

        return to_route("service.live-chat.other-options");
    }

    public function endChat(LiveChat $liveChat): RedirectResponse
    {
        $liveChat->update([
            "is_active" => false,
            "ended_at" => now()
        ]);

        $agentStatus = AgentStatus::where("agent_id", $liveChat->agent_id)->first();

        if($agentStatus) {

            $agentStatus->update([
                "current_chat_count" => $agentStatus->current_chat_count - 1,
                "chat_status" => $agentStatus->max_chat_capacity > $agentStatus->current_chat_count - 1 ? "avaliable" : "busy"
        ]);
        }

        return to_route("home");
    }


    public function otherOption(): Response|ResponseFactory
    {
        return inertia("Ecommerce/HelpCenter/LiveChat/OtherOption");
    }

}
