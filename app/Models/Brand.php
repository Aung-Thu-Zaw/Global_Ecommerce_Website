<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Searchable;

    protected $guarded=[];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/brands/$value"),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

    public static function deleteImage($brand)
    {
        if (!empty($brand->image) && file_exists(storage_path("app/public/brands/$brand->image"))) {
            unlink(storage_path("app/public/brands/$brand->image"));
        }
    }
}
