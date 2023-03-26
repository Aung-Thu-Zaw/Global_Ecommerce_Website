<?php

namespace App\Actions;

use App\Models\Color;
use Illuminate\Http\Request;

class CreateProductColorAction
{
    public function execute(Request $request, $product)
    {
        if ($request->input("colors")) {
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
