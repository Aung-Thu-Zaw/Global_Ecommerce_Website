<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class OrderItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Product,OrderItem>
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Order,OrderItem>
    */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
