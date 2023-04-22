<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Region extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use HasSlug;

    /**
    * @var string[]
    */
    protected array $cascadeDeletes = ['cities'];
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
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Region, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Country,Region>
    */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }



    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<City>
    */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

}
