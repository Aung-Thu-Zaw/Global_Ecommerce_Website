<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryInformation extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,DeliveryInformation>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
