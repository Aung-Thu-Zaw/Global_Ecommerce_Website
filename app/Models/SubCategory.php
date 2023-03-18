<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class SubCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded=[];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'status' => $this->status,
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/subCategories/$value"),
        );
    }

    public static function deleteImage($subCategory)
    {
        if (!empty($subCategory->image) && file_exists(storage_path("app/public/subCategories/$subCategory->image"))) {
            unlink(storage_path("app/public/subCategories/$subCategory->image"));
        }
    }
}
