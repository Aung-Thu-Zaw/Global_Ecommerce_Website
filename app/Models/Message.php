<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Message, never>
    */
    protected function imagePath(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/message-files/images/$value"),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<Message, never>
    */
    protected function videoPath(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_starts_with($value, "http") ? $value : asset("storage/message-files/videos/$value"),
        );
    }

    /**
    * @return \Illuminate\Database\Eloquent\Casts\Attribute<ProductQuestion, never>
    */
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => date("j-F-Y", strtotime($value))." ( ".Carbon::parse($value)->diffForHumans()." ) ",
        );

    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Message>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
