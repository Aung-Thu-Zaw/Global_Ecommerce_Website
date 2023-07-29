<?php

namespace App\Services\Products;

use App\Models\Color;
use App\Models\Product;

class HandleProductColorService
{
    /**
     * @param array<string> $colors
     */

    public function handle(array $colors, Product $product): void
    {
        $product->colors()->detach();

        foreach ($colors as $color) {
            $countExisitngColors=Color::where("name", $color)->count();

            $exisitngColors=Color::where("name", $color)->get();

            if (!$countExisitngColors) {
                $colorModel=new Color();
                $colorModel->name=$color;
                $colorModel->save();
                $product->colors()->attach($colorModel);
            }

            if ($countExisitngColors) {
                foreach ($exisitngColors as $existingColor) {
                    $product->colors()->attach($existingColor);
                }
            }
        }
    }
}
