<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAnswer extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductAnswer, never>
    */
    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j/F/Y h:i:s A", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,ProductAnswer>
    */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class,"seller_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<ProductQuestion,ProductAnswer>
    */
    public function productQuestion(): BelongsTo
    {
        return $this->belongsTo(ProductQuestion::class);
    }
}
