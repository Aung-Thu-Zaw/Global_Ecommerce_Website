<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Banner extends Model
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
            'url' => $this->url,
        ];
    }

        /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Banner, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("Y/m/d", strtotime($value)),
        );
    }

        /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Banner, never>
    */
    protected function image(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/banners/$value"),
        );
    }

    public static function deleteImage(object $banner): void
    {
        if (!empty($banner->image) && file_exists(storage_path("app/public/banners/".pathinfo($banner->image, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/banners/".pathinfo($banner->image, PATHINFO_BASENAME)));
        }
    }
}
