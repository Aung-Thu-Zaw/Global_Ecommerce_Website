<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Searchable;

    protected $guarded=[];

    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['subCategories'];

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


    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Category, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/categories/$value"),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Category, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

    public static function deleteImage(object $category): void
    {
        if (!empty($category->image) && file_exists(storage_path("app/public/categories/$category->image"))) {
            unlink(storage_path("app/public/categories/$category->image"));
        }
    }
}
