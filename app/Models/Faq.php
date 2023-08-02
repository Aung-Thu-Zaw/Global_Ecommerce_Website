<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Faq extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $guarded=[];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('question')
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
            'question' => $this->question,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Faq, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Faq, never>
    */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<FaqCategory,Faq>
    */
    public function faqCategory(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<FaqSubCategory,Faq>
    */
    public function faqSubCategory(): BelongsTo
    {
        return $this->belongsTo(FaqSubCategory::class);
    }

}
