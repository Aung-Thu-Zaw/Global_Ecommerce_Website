<?php

namespace App\Services\Chats;

use App\Models\ChatFileAttachment;
use App\Models\LiveChatMessage;
use Illuminate\Http\UploadedFile;

class ChatMultiFileUploadService
{
    /**
     * @param array<UploadedFile> $files
     */
    public function createMultiImage(array $files, LiveChatMessage $liveChatMessage): void
    {
        foreach ($files as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {

                $file->move(storage_path('app/public/live-chats/images/'), $originalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "image",
                    "attachment_path" => $originalName,
                ]);

            } elseif (in_array($extension, ['avi','mpeg','webm','mp4'])) {

                $file->move(storage_path('app/public/live-chats/videos/'), $originalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "video",
                    "attachment_path" => $originalName,
                ]);

            } elseif (in_array($extension, ['pdf','msword','vnd.ms-excel','vnd','ms-powerpoint','plain','csv','zip','x-rar-compressed','x-7z-compressed'])) {

                $file->move(storage_path('app/public/live-chats/files/'), $originalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "file",
                    "attachment_path" => $originalName,
                ]);

            } elseif (in_array($extension, ['mpeg','wav','ogg'])) {

                $file->move(storage_path('app/public/live-chats/audios/'), $originalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "audio",
                    "attachment_path" => $originalName,
                ]);
            }
        }
    }
}
