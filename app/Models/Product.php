<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/categories/$value"),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }
}
