<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlashSale extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany<FlashSaleItem>
    */
    public function flashSaleItems(): HasMany
    {
        return $this->hasMany(FlashSaleItem::class);
    }
}
