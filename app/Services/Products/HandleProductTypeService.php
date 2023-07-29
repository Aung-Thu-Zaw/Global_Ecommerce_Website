<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Models\Type;

class HandleProductTypeService
{
    /**
     * @param array<string> $types
     */

    public function handle(array $types, Product $product): void
    {
        $product->types()->detach();

        foreach ($types as $type) {
            $countExisitngTypes=Type::where("name", $type)->count();

            $exisitngTypes=Type::where("name", $type)->get();

            if (!$countExisitngTypes) {
                $typeModel=new Type();
                $typeModel->name=$type;
                $typeModel->save();
                $product->types()->attach($typeModel);
            }

            if ($countExisitngTypes) {
                foreach ($exisitngTypes as $exisitngType) {
                    $product->types()->attach($exisitngType);
                }
            }
        }
    }
}
