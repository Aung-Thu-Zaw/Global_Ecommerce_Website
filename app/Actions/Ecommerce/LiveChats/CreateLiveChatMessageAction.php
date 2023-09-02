<?php

namespace App\Actions\Ecommerce\LiveChats;

use App\Models\LiveChatMessage;
use App\Services\Chats\ChatMultiFileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

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
                        ]);


        if(isset($data["files"])) {

            (new ChatMultiFileUploadService())->createMultiImage($data["files"], $liveChatMessage);

        }

        return $liveChatMessage;
    }

}
