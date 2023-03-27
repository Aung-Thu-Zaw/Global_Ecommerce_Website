<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use HasSlug;



    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['subCategories'];
    protected $guarded=[];

    protected $casts = [
        'hot_deal' => 'boolean',
        'special_offer' => 'boolean',
        'featured' => 'boolean',
    ];


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
            'status' => $this->status,
        ];
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Product, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/products/$value"),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Product, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }


    protected function hotDeal(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }

    protected function specialOffer(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }

    protected function featured(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }



    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    public static function deleteImage(object $product): void
    {
        if (!empty($product->image) && file_exists(storage_path("app/public/products/".pathinfo($product->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/products/".pathinfo($product->image, PATHINFO_BASENAME)));
        }
    }
}
