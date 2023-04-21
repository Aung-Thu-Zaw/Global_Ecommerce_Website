<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;

class PostalCode extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;


    protected $guarded=[];


    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'code' => $this->code,

        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Township,PostalCode>
    */
    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class);
    }

}
