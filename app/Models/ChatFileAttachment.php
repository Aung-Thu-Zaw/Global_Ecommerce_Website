<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatFileAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<LiveChatMessage, never>
     */
    protected function attachmentPath(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value && str_starts_with($value, 'image')) {
                    return asset("storage/live-chats/images/$value");
                } elseif ($value && str_starts_with($value, 'video')) {
                    return asset("storage/live-chats/videos/$value");
                } elseif ($value && str_starts_with($value, 'file')) {
                    return asset("storage/live-chats/files/$value");
                } elseif ($value && str_starts_with($value, 'audio')) {
                    return asset("storage/live-chats/audios/$value");
                }
            },
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LiveChatMessage,ChatFileAttachment>
     */
    public function liveChatMessage(): BelongsTo
    {
        return $this->belongsTo(LiveChatMessage::class);
    }

    // public static function deleteAttachment(ChatFileAttachment $chatFileAttachment): void
    // {

    //     if (!empty($chatFileAttachment->attachment_path) && file_exists(storage_path("app/public/chats/".pathinfo($chatFileAttachment->attachment_path, PATHINFO_BASENAME)))) {
    //         unlink(storage_path("app/public/product-reviews/".pathinfo($chatFileAttachment->attachment_path, PATHINFO_BASENAME)));
    //     }
    // }
}
