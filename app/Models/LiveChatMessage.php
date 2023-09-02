<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveChatMessage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<ChatFileAttachment>
    */
    public function chatFileAttachments(): HasMany
    {
        return $this->hasMany(ChatFileAttachment::class);
    }
}
