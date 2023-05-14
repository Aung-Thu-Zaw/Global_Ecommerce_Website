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
    protected array $cascadeDeletes = ['category'];
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
            // 'status' => $this->status,
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
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Product, never>
    */
    protected function hotDeal(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Product, never>
    */
    protected function specialOffer(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Product, never>
    */
    protected function featured(): Attribute
    {
        return Attribute::make(
            get : fn ($value) => (bool) $value
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Image>
    */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Brand,Product>
    */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Product>
    */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id");
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Color>
    */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Color::class, 'product_color');
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Size>
    */
    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category,Product>
    */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<CartItem>
    */
     public function cartItems(): HasMany
     {
         return $this->hasMany(CartItem::class);
     }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Watchlist>
    */
    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<OrderItem>
    */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<ProductQuestion>
    */
    public function productQuestions(): HasMany
    {
        return $this->hasMany(ProductQuestion::class);
    }


    public static function deleteImage(Product $product): void
    {
        if (!empty($product->image) && file_exists(storage_path("app/public/products/".pathinfo($product->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/products/".pathinfo($product->image, PATHINFO_BASENAME)));
        }
    }
}
