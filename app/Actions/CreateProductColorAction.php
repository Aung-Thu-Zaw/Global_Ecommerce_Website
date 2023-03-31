<?php

namespace App\Actions;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class CreateProductColorAction
{
    public function handle(Request $request, Product $product): void
    {
        if ($request->input("colors")) {
            $product->colors()->detach();
            foreach ($request->colors as $color) {
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
}
