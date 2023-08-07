<?php

namespace App\Actions\Products;

use App\Models\Image;
use App\Models\Product;

class PermanentlyDeleteTrashProductAction
{
    public function handle(Product $product): void
    {
        $multiImages=Image::where("product_id", $product->id)->get();

        $multiImages->each(function ($image) {

            Image::deleteImage($image);

        });

        Product::deleteImage($product->image);

        $product->forceDelete();
    }
}
