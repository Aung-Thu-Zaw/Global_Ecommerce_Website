<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveChat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,LiveChat>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,LiveChat>
    */
    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, "agent_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<LiveChatMessage>
    */
    public function liveChatMessages(): HasMany
    {
        return $this->hasMany(LiveChatMessage::class);
    }


}
