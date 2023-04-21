<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Collection extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Searchable;
    use HasSlug;

    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['products'];
    protected $guarded=[];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
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
            'title' => $this->title,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Collection, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/collections/$value"),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Collection, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Product>
    */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public static function deleteImage(Collection $collection): void
    {
        if (!empty($collection->image) && file_exists(storage_path("app/public/collections/".pathinfo($collection->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/collections/".pathinfo($collection->image, PATHINFO_BASENAME)));
        }
    }
}