<?php

namespace App\Http\Controllers\Ecommerce\HelpCenter\LiveChats;

use App\Actions\Ecommerce\LiveChats\CreateLiveChatMessageAction;
use App\Events\LiveChatMessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\LiveChatMessageRequest;
use App\Models\LiveChatMessage;
use Illuminate\Http\Request;

class LiveChatMessageController extends Controller
{
    public function store(LiveChatMessageRequest $request): void
    {
        $message = (new CreateLiveChatMessageAction())->handle($request->validated());

        if($message) {
            event(new LiveChatMessageSent($message));
        }
    }

    public function update(LiveChatMessageRequest $request, int $liveChatMessageId): void
    {
        $liveChatMessage = LiveChatMessage::findOrFail($liveChatMessageId);

        $liveChatMessage->update([
            "message" => $request->message,
            "is_edited" => true
        ]);
    }

    public function deleteMessageForMyself(Request $request, int $liveChatMessageId): void
    {
        $liveChatMessage = LiveChatMessage::findOrFail($liveChatMessageId);

        $liveChatMessage->update([
            "is_deleted_by_user" => $request->is_deleted_by_user,
            "is_deleted_by_agent" => $request->is_deleted_by_agent
        ]);
    }

    public function destroy(int $liveChatMessageId): void
    {
        $liveChatMessage = LiveChatMessage::findOrFail($liveChatMessageId);

        $liveChatMessage->delete();
    }
}
