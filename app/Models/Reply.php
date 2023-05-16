<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Reply, never>
    */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y h:i:s A", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ProductReview,Reply>
    */
    public function productReview(): BelongsTo
    {
        return $this->belongsTo(ProductReview::class);
    }
    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Reply>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
