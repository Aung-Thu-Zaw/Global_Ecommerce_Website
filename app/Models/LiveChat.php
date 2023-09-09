<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

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

    /**
    * @param array<string> $filterBy
    * @param Builder<LiveChat> $query
    */

    public function scopeFilterBy(Builder $query, array $filterBy): void
    {
        $query->when($filterBy["search"] ?? null, function ($query, $search) {
            $query->whereHas("user", function ($query) use ($search) {
                $query->where("name", "like", '%' . $search . '%');
            });
        });

        $query->when(
            $filterBy["tab"] === 'ongoing-chats',
            function ($query) {
                $query->where(
                    function ($query) {
                        $query->where("is_active", 1)->where("ended_at", null);
                    }
                );
            }
        );

        $query->when(
            $filterBy["tab"] === 'ended-chats',
            function ($query) {
                $query->where(
                    function ($query) {
                        $query->where("is_active", 0)->whereNotNull("ended_at");
                    }
                );
            }
        );
    }
}
