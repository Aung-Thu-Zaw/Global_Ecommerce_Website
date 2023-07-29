<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Image, never>
    */
    protected function imgPath(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value && str_starts_with($value, "http")) {
                    return $value;
                } elseif ($value&& str_starts_with($value, "suggestion")) {
                    return asset("storage/suggestions/$value");
                } elseif ($value&& str_starts_with($value, "product")) {
                    return asset("storage/products/$value");
                } else {
                    return null;
                }
            },
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Product,Image>
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function deleteImage(Image $image): void
    {

        if($image->product_id) {

            if (!empty($image->img_path) && file_exists(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)))) {
                unlink(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)));
            }

        } else {

            if (!empty($image->img_path) && file_exists(storage_path("app/public/suggestions/".pathinfo($image->img_path, PATHINFO_BASENAME)))) {
                unlink(storage_path("app/public/suggestions/".pathinfo($image->img_path, PATHINFO_BASENAME)));
            }

        }
    }
}
