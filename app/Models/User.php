<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use Searchable;

    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
    *     @return array<string>
    */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<User, never>
    */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value)
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<User, never>
    */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/avatars/$value"),
            get: fn ($value) => $value ??  asset("storage/avatars/default-avatar-".auth()->user()->id.".png"),
        );
    }


    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<User, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value)),
        );
    }


        /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne<Cart>
    */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Watchlist>
    */
    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Coupon>
    */
    public function coupons(): BelongsToMany
    {
        return $this->belongsToMany(Coupon::class)
            ->withPivot('used_at')
            ->withTimestamps();
    }


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne<DeliveryInformation>
    */
    public function deliveryInformation(): HasOne
    {
        return $this->hasOne(DeliveryInformation::class);
    }



    public function getRedirectRouteName(): string
    {
        return match ((string)$this->role) {
            "admin"=>"admin.dashboard",
            "vendor"=>"vendor.dashboard",
            "user"=>"home",
        };
    }

    public function logoutRedirect(): string
    {
        return match ((string)$this->role) {
            "admin"=>"admin.login",
            "vendor"=>"vendor.login",
            "user"=>"home",
        };
    }




    public static function deleteDefaultAvatar(User $user): void
    {
        if (file_exists(storage_path("app/public/avatars/default-avatar-".$user->id.".png"))) {
            unlink(storage_path("app/public/avatars/default-avatar-".$user->id.".png"));
        }
    }

    public static function deleteUserAvatar(User $user): void
    {
        if (!empty($user->avatar) && file_exists(storage_path("app/public/avatars/".pathinfo($user->avatar, PATHINFO_BASENAME)))) {
            unlink(storage_path("app/public/avatars/".pathinfo($user->avatar, PATHINFO_BASENAME)));
        }
    }
}
