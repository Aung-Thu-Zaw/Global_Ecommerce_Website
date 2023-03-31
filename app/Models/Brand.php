<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Searchable;
    use HasSlug;

    protected $guarded=[];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Brand, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/brands/$value"),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Brand, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }


    public static function deleteImage(Brand $brand): void
    {
        if (!empty($brand->image) && file_exists(storage_path("app/public/brands/".pathinfo($brand->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/brands/".pathinfo($brand->image, PATHINFO_BASENAME)));
        }
    }
}
