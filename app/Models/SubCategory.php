<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class SubCategory extends Model
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
            'name' => $this->name,
            'status' => $this->status,
        ];
    }


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<SubCategory, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/subCategories/$value"),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<SubCategory, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

    public static function deleteImage(object $subCategory): void
    {
        if (!empty($subCategory->image) && file_exists(storage_path("app/public/subCategories/$subCategory->image"))) {
            unlink(storage_path("app/public/subCategories/$subCategory->image"));
        }
    }
}
