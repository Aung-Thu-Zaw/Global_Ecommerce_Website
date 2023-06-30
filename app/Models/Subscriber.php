<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded=[];

    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'email' => $this->email,
        ];
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Subscriber, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Subscriber, never>
    */
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }
}
