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
}
