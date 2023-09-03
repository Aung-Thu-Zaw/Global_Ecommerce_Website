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

                $finalName = "image"."-".time()."-".$originalName;
                $file->move(storage_path('app/public/live-chats/images/'), $finalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "image",
                    "attachment_path" => $finalName,
                ]);

            } elseif (in_array($extension, ['avi','mpeg','webm','mp4'])) {

                $finalName = "video"."-".time()."-".$originalName;
                $file->move(storage_path('app/public/live-chats/videos/'), $finalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "video",
                    "attachment_path" => $finalName,
                ]);

            } elseif (in_array($extension, ['pdf','msword','vnd.ms-excel','vnd','ms-powerpoint','plain','csv','zip','x-rar-compressed','x-7z-compressed'])) {

                $finalName = "file"."-".time()."-".$originalName;
                $file->move(storage_path('app/public/live-chats/files/'), $finalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "file",
                    "attachment_path" => $finalName,
                ]);

            } elseif (in_array($extension, ['mpeg','wav','ogg'])) {

                $finalName = "audio"."-".time()."-".$originalName;
                $file->move(storage_path('app/public/live-chats/audios/'), $finalName);

                ChatFileAttachment::create([
                    "live_chat_message_id" => $liveChatMessage->id,
                    "type" => "audio",
                    "attachment_path" => $finalName,
                ]);
            }
        }
    }
}
