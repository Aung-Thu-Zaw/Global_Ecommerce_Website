<?php

namespace App\Actions\Seller\Products;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashProductAction
{
    /**
    * @param Collection<int,Product> $products
    */

    public function handle(Collection $products): void
    {
        $products->each(function ($product) {

            $multiImages=Image::where("product_id", $product->id)->get();

            $multiImages->each(function ($image) {

                Image::deleteImage($image);

            });

            Product::deleteImage($product->image);

            $product->forceDelete();

        });
    }
}
