<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveChatMessage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,LiveChatMessage>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<LiveChatMessage, never>
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y ( l )', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<LiveChatMessage, never>
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('h:i A', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,LiveChatMessage>
     */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<ChatFileAttachment>
     */
    public function chatFileAttachments(): HasMany
    {
        return $this->hasMany(ChatFileAttachment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<LiveChatMessage,LiveChatMessage>
     */
    public function replyToMessage(): BelongsTo
    {
        return $this->belongsTo(LiveChatMessage::class, 'reply_to_message_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<LiveChatMessage>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class, 'reply_to_message_id');
    }
}
