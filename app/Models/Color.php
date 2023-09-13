<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Color, never>
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
        return $this->belongsToMany(Product::class, "product_color");
    }
}
