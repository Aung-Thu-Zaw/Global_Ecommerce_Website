<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded=[];


    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<Message>
    */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Conversation>
    */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, "customer_id");
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Conversation>
    */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, "vendor_id");
    }

}
