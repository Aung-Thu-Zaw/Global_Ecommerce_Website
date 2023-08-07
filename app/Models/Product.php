<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
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
    protected function deletedAt(): Attribute
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
        return $this->belongsTo(User::class, "seller_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Collection,Product>
    */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
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
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Type>
    */
    public function types(): BelongsToMany
    {
        return $this->belongsToMany(Type::class);
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

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<ProductReview>
    */
    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public static function deleteImage(string $productImage): void
    {
        if (!empty($productImage) && file_exists(storage_path("app/public/products/".pathinfo($productImage, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/products/".pathinfo($productImage, PATHINFO_BASENAME)));
        }
    }

    /**
    * @param array<string> $filterBy
    * @param Builder<Product> $query
    */

    public function scopeFilterBy(Builder $query, array $filterBy): void
    {
        $query->when(
            $filterBy["search"]??null,
            function ($query, $search) {
                $query->where(
                    function ($query) use ($search) {
                        $query->where("name", "LIKE", "%".$search."%");
                    }
                );
            }
        );

        $query->when($filterBy["price"] ?? null, function ($query, $price) {
            if ($price !== null) {
                $priceRange = explode("-", $price);

                if (count($priceRange) === 2) {
                    $minPrice = $priceRange[0];
                    $maxPrice = $priceRange[1];

                    $query->where(function ($query) use ($minPrice, $maxPrice) {
                        $query->whereBetween("price", [$minPrice, $maxPrice])
                            ->orWhereBetween("discount", [$minPrice, $maxPrice]);
                    });
                }
            }
        });


        $query->when($filterBy["category"]?? null, function ($query, $categorySlug) {
            $query->whereHas("category", function ($query) use ($categorySlug) {
                $query->where("slug", $categorySlug);
            });
        });

        $query->when($filterBy["brand"]?? null, function ($query, $brandSlug) {
            $query->whereHas("brand", function ($query) use ($brandSlug) {
                $query->where("slug", $brandSlug);
            });
        });

        // $query->when($filterBy["rating"]?? null, function ($query, $rating) {
        //     $query->whereHas("productReviews", function ($query) use ($rating) {
        //         $query->groupBy("product_id")
        //               ->havingRaw("AVG(rating) >= ?", [$rating]);
        //     });
        // });
    }
}
