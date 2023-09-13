<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\Size;

class HandleProductSizeService
{
    /**
     * @param array<string> $sizes
     */

    public function handle(array $sizes, Product $product): void
    {
        $product->sizes()->detach();

        $filteredSizes = array_unique(array_map('strtolower', $sizes));

        $attachedSizeIds = $product->sizes()->pluck('id')->toArray();

        foreach ($filteredSizes as $size) {
            $existedSize = Size::where("name", $size)->first();

            if (!$existedSize) {
                $sizeModel = Size::create(["name" => $size]);

                $product->sizes()->attach($sizeModel);
            } elseif (!in_array($existedSize->id, $attachedSizeIds)) {
                $product->sizes()->attach($existedSize);
            }
        }

    }
}
