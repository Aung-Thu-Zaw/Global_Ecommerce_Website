<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ShopReview extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded=[];

    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'review_text' => $this->review_text,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductReview, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y ( h:i:s A )", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ShopReview, never>
    */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y h:i:s A", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ShopReview>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ShopReview>
    */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(User::class, "vendor_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne<Reply>
    */
    public function reply(): HasOne
    {
        return $this->hasOne(Reply::class);
    }
}
