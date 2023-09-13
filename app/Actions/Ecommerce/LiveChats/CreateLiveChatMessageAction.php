<?php

namespace App\Actions\Ecommerce\LiveChats;

use App\Models\LiveChatMessage;
use App\Services\UploadFiles\ChatMultiFileUploadService;

class CreateLiveChatMessageAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): ?LiveChatMessage
    {

        $liveChatMessage = LiveChatMessage::create([
                            'live_chat_id' => $data["live_chat_id"],
                            'user_id' => $data["user_id"],
                            'agent_id' => $data["agent_id"],
                            'message' => $data["message"],
                            'is_read_by_user' => $data["user_id"] ? true : false,
                            'is_read_by_agent' => $data["agent_id"] ? true : false,
                            'reply_to_message_id' => $data["reply_to_message_id"] ?? null,
                        ]);


        if(isset($data["files"])) {

            (new ChatMultiFileUploadService())->createMultiImage($data["files"], $liveChatMessage);

        }

        return $liveChatMessage;
    }

}
