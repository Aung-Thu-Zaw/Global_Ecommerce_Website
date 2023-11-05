<?php

namespace App\Models;

use App\Models\Scopes\FilteredByDateScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class BlogComment extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $guarded = [];

    /**
     *     @return array<string>
     */
    #[SearchUsingFullText(['comment'])]
    public function toSearchableArray(): array
    {
        return [
            'comment' => $this->comment,
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new FilteredByDateScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogPost, never>
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('F j, Y', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogCommentReply, never>
     */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j/F/Y h:i:s A', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogPost, never>
     */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,BlogComment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<BlogPost,BlogComment>
     */
    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<BlogCommentReply>
     */
    public function blogCommentReply(): HasOne
    {
        return $this->hasOne(BlogCommentReply::class);
    }
}
