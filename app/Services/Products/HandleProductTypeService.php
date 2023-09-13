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

        $filteredTypes = array_unique(array_map('strtolower', $types));

        $attachedTypeIds = $product->types()->pluck('id')->toArray();

        foreach ($filteredTypes as $type) {
            $existedType = Type::where("name", $type)->first();

            if (!$existedType) {
                $typeModel = Type::create(["name" => $type]);

                $product->types()->attach($typeModel);
            } elseif (!in_array($existedType->id, $attachedTypeIds)) {
                $product->types()->attach($existedType);
            }
        }
    }
}
