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

        foreach ($sizes as $size) {
            $countExisitngSizes=Size::where("name", $size)->count();

            $exisitngSizes=Size::where("name", $size)->get();

            if (!$countExisitngSizes) {
                $sizeModel=new Size();
                $sizeModel->name=$size;
                $sizeModel->save();
                $product->sizes()->attach($sizeModel);
            }

            if ($countExisitngSizes) {
                foreach ($exisitngSizes as $exisitngSize) {
                    $product->sizes()->attach($exisitngSize);
                }
            }
        }
    }
}
