<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;


    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<DeliveryInformation,Order>
    */
    public function deliveryInformation(): BelongsTo
    {
        return $this->belongsTo(DeliveryInformation::class);
    }

}
