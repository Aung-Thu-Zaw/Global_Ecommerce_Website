<?php

namespace App\Services\Products;

use App\Models\Color;
use App\Models\Product;

class HandleProductColorService
{
    /**
     * @param  array<string>  $colors
     */
    public function handle(array $colors, Product $product): void
    {
        $product->colors()->detach();

        $filteredColors = array_unique(array_map('strtolower', $colors));

        $attachedColorIds = $product->colors()->pluck('id')->toArray();

        foreach ($filteredColors as $color) {
            $existedColor = Color::where('name', $color)->first();

            if (! $existedColor) {
                $colorModel = Color::create(['name' => $color]);

                $product->colors()->attach($colorModel);
            } elseif (! in_array($existedColor->id, $attachedColorIds)) {
                $product->colors()->attach($existedColor);
            }
        }
    }
}
