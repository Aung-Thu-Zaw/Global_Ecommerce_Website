<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogCommentReply extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogCommentReply, never>
    */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y h:i:s A", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<BlogComment,BlogCommentReply>
    */
    public function blogComment(): BelongsTo
    {
        return $this->belongsTo(BlogComment::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,BlogCommentReply>
    */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, "author_id");
    }
}
