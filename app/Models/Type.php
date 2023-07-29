<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Type extends Model
{
    use HasFactory;

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Type, never>
    */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Product>
    */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, "product_type");
    }
}
