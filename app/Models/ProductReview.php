<?php

namespace App\Models;

use App\Models\Scopes\FilteredByDateScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProductReview extends Model
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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new FilteredByDateScope());
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductReview, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y ( h:i A )", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductReview, never>
    */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y ( h:i A )", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductReview, never>
    */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y ( h:i A )", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ProductReview>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne<Reply>
    */
    public function reply(): HasOne
    {
        return $this->hasOne(Reply::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Product,ProductReview>
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
