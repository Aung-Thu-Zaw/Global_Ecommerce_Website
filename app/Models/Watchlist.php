<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watchlist extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User,Watchlist>
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Product,Watchlist>
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
