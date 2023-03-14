<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'created_at'=>'date'
    ];


    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/avatars/$value"),
            get: fn ($value) => $value ??  asset("storage/avatars/default-avatar-".auth()->user()->id.".png"),
        );
    }


    public function getRedirectRouteName()
    {
        return match ((string)$this->role) {
            "admin"=>"admin.dashboard",
            "vendor"=>"vendor.dashboard",
            "user"=>"home",
        };
    }

    public function logoutRedirect()
    {
        return match ((string)$this->role) {
            "admin"=>"admin.login",
            "vendor"=>"vendor.login",
            "user"=>"home",
        };
    }

    public static function deleteDefaultAvatar($user)
    {
        if (file_exists(storage_path("app/public/avatars/default-avatar-$user->id.png"))) {
            unlink(storage_path("app/public/avatars/default-avatar-$user->id.png"));
        }
    }

    public static function deleteUserAvatar($user)
    {
        if (!empty($user->avatar) && file_exists(storage_path("app/public/avatars/$user->avatar"))) {
            unlink(storage_path("app/public/avatars/$user->avatar"));
        }
    }

    // if (file_exists(storage_path("app/public/avatars/default-avatar-$user->id.png"))) {
    //     unlink(storage_path("app/public/avatars/default-avatar-$user->id.png"));
    // }

    // if (!empty($request->user()->avatar) && file_exists(storage_path("app/public/avatars/$user->avatar"))) {
    //     unlink(storage_path("app/public/avatars/$user->avatar"));
    // }
}
