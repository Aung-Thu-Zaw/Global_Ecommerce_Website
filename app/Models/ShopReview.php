<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShopReview extends Model
{
    use HasFactory;

    protected $guarded=[];

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
    * @return \Illuminate\Database\Eloquent\Relations\HasOne<Reply>
    */
    public function reply(): HasOne
    {
        return $this->hasOne(Reply::class);
    }
}
