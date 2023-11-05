<?php

namespace App\Models;

use App\Models\Scopes\FilteredByDateScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogCategory extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use HasSlug;

    /**
     * @var string[]
     */
    protected $guarded = [];

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
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new FilteredByDateScope());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogCategory, never>
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                if ($value && str_starts_with($value, 'http')) {
                    return $value;
                } elseif ($value) {
                    return asset("storage/blog-categories/$value");
                } else {
                    return null;
                }
            },
            get:fn ($value) => $value ?? 'https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns='
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogCategory, never>
     */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y', strtotime($value)),
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<BlogPost>
     */
    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogCategory, never>
     */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date('j-F-Y', strtotime($value)),
        );
    }

    public static function deleteImage(string $blogCategoryImage): void
    {
        if (! empty($blogCategoryImage) && file_exists(storage_path('app/public/blog-categories/'.pathinfo($blogCategoryImage, PATHINFO_BASENAME)))) {
            unlink(storage_path('app/public/blog-categories/'.pathinfo($blogCategoryImage, PATHINFO_BASENAME)));
        }
    }
}
