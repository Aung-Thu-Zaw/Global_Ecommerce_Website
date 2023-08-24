<?php

namespace App\Actions\Seller\Products;

use App\Models\Product;
use App\Services\ProductImageUploadService;
use App\Services\ProductMultiImageUploadService;
use App\Services\Products\HandleProductColorService;
use App\Services\Products\HandleProductSizeService;
use App\Services\Products\HandleProductTypeService;

class CreateProductAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): Product
    {
        $image = isset($data["image"]) ? (new ProductImageUploadService())->createImage($data["image"]) : null;

        $product=Product::create([
            "brand_id"=>$data["brand_id"],
            "category_id"=>$data["category_id"],
            "seller_id"=>$data["seller_id"],
            "name"=>$data["name"],
            "code"=>$data["code"],
            "qty"=>$data["qty"],
            "price"=>$data["price"],
            "discount"=>$data["discount"],
            "description"=>$data["description"],
            "featured"=>$data["featured"],
            "special_offer"=>$data["special_offer"],
            "status"=>$data["status"],
            "image"=>$image,
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

        return $product;

    }
}
