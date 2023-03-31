<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProductBanner extends Model
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
            'title' => $this->title,
            'url' => $this->url,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductBanner, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductBanner, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/product-banners/$value"),
        );
    }

    public static function deleteImage(ProductBanner $productBanner): void
    {
        if (!empty($productBanner->image) && file_exists(storage_path("app/public/product-banners/".pathinfo($productBanner->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/product-banners/".pathinfo($productBanner->image, PATHINFO_BASENAME)));
        }
    }
}