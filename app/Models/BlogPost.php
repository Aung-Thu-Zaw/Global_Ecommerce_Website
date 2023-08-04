<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use HasSlug;

    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['blogCategory'];
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
    #[SearchUsingFullText(['description'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogPost, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/blog-posts/$value"),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogPost, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("F j, Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<BlogPost, never>
    */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<BlogCategory,BlogPost>
    */
    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,BlogPost>
    */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, "author_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<BlogTag>
    */
    public function blogTags(): BelongsToMany
    {
        return $this->belongsToMany(BlogTag::class, "blog_post_blog_tag");
    }

    public static function deleteImage(string $blogPostImage): void
    {
        if (!empty($blogPostImage) && file_exists(storage_path("app/public/blog-posts/".pathinfo($blogPostImage, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/blog-posts/".pathinfo($blogPostImage, PATHINFO_BASENAME)));
        }
    }

    /**
    * @param array<string> $filterBy
    * @param Builder<BlogPost> $query
    */

    public function scopeFilterBy(Builder $query, array $filterBy): void
    {
        $query->when(
            $filterBy["search_blog"]??null,
            function ($query, $search_blog) {
                $query->where(
                    function ($query) use ($search_blog) {
                        $query->where("title", "LIKE", "%".$search_blog."%")
                              ->orWhere("description", "LIKE", "%".$search_blog."%");
                    }
                );
            }
        );

        $query->when($filterBy["blog_category"]?? null, function ($query, $categorySlug) {
            $query->whereHas("blogCategory", function ($query) use ($categorySlug) {
                $query->where("slug", $categorySlug);
            });
        });
    }
}
