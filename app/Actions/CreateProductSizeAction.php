<?php

namespace App\Actions;

use App\Models\Size;
use Illuminate\Http\Request;

class CreateProductSizeAction
{
    public function execute(Request $request, $product)
    {
        if ($request->input("sizes")) {
            foreach ($request->sizes as $size) {
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
}
