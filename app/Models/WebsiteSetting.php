<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<WebsiteSetting, never>
    */
    protected function logo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/website-settings/$value"),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<WebsiteSetting, never>
    */
    protected function favicon(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/website-settings/$value"),
        );
    }

    public static function deleteLogo(string $logoImage): void
    {
        if (!empty($logoImage) && file_exists(storage_path("app/public/website-settings/".pathinfo($logoImage, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/website-settings/".pathinfo($logoImage, PATHINFO_BASENAME)));
        }
    }

    public static function deleteFavicon(string $faviconImage): void
    {
        if (!empty($faviconImage) && file_exists(storage_path("app/public/website-settings/".pathinfo($faviconImage, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/website-settings/".pathinfo($faviconImage, PATHINFO_BASENAME)));
        }
    }
}
