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
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/products/$value"),
        );
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function deleteImage(object $image): void
    {
        if (!empty($image->img_path) && file_exists(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)));
        }
    }

    public static function deleteMultiImage(object $multiImages): void
    {
        if ($multiImages) {
            foreach ($multiImages as $image) {
                if (!empty($image->img_path) && file_exists(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)))) {
                    unlink(storage_path("app/public/products/".pathinfo($image->img_path, PATHINFO_BASENAME)));
                }
            }
        }
    }
}
