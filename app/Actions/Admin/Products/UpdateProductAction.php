<?php

namespace App\Actions\Admin\Products;

use App\Models\Product;
use App\Services\ProductImageUploadService;
use App\Services\ProductMultiImageUploadService;
use App\Services\Products\HandleProductColorService;
use App\Services\Products\HandleProductSizeService;
use App\Services\Products\HandleProductTypeService;

class UpdateProductAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Product $product): void
    {
        $image = isset($data["image"]) ? (new ProductImageUploadService())->updateImage($data["image"], $product->image) : $product->image;

        $product->update([
            "brand_id" => $data["brand_id"],
            "category_id" => $data["category_id"],
            "seller_id" => $data["seller_id"],
            "collection_id" => $data["collection_id"],
            "name" => $data["name"],
            "code" => $data["code"],
            "qty" => $data["qty"],
            "price" => $data["price"],
            "discount" => $data["discount"],
            "description" => $data["description"],
            "hot_deal" => $data["hot_deal"],
            "featured" => $data["featured"],
            "special_offer" => $data["special_offer"],
            "status" => $data["status"],
            "return_policy" => $data["return_policy"],
            "image" => $image,
        ]);

        if(isset($data["sizes"])) {

            (new HandleProductSizeService())->handle($data["sizes"], $product);

        }

        if(isset($data["colors"])) {

            (new HandleProductColorService())->handle($data["colors"], $product);

        }

        if(isset($data["types"])) {

            (new HandleProductTypeService())->handle($data["types"], $product);

        }

        if(isset($data["multi_image"])) {

            (new ProductMultiImageUploadService())->createMultiImage($data["multi_image"], $product);

        }
    }
}
