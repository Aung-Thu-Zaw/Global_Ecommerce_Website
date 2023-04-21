<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Township extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use HasSlug;


    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['postalCodes'];
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
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<City,Township>
    */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }



    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<PostalCode>
    */
    public function postalCodes(): HasMany
    {
        return $this->hasMany(PostalCode::class);
    }

}
