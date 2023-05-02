<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<DeliveryInformation,Order>
    */
    public function deliveryInformation(): BelongsTo
    {
        return $this->belongsTo(DeliveryInformation::class);
    }

}
