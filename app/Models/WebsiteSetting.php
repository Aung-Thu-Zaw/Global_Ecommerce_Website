<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<WebsiteSetting, never>
    */
    protected function logo(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/website-settings/$value"),
            get:fn ($value) => $value ?? "https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<WebsiteSetting, never>
    */
    protected function favicon(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/website-settings/$value"),
            get:fn ($value) => $value ?? "https://media.istockphoto.com/id/1357365823/vector/default-image-icon-vector-missing-picture-page-for-website-design-or-mobile-app-no-photo.jpg?s=612x612&w=0&k=20&c=PM_optEhHBTZkuJQLlCjLz-v3zzxp-1mpNQZsdjrbns="
        );
    }

    public static function deleteLogo(WebsiteSetting $websiteSetting): void
    {
        if (!empty($websiteSetting->logo) && file_exists(storage_path("app/public/website-settings/".pathinfo($websiteSetting->logo, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/website-settings/".pathinfo($websiteSetting->logo, PATHINFO_BASENAME)));
        }
    }

    public static function deleteFavicon(WebsiteSetting $websiteSetting): void
    {
        if (!empty($websiteSetting->favicon) && file_exists(storage_path("app/public/website-settings/".pathinfo($websiteSetting->favicon, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/website-settings/".pathinfo($websiteSetting->favicon, PATHINFO_BASENAME)));
        }
    }
}
