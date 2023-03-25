<?php

namespace App\Actions;

use App\Models\Size;
use Illuminate\Http\Request;

class CreateProductSizeAction
{
    public function execute(Request $request, $product)
    {
        if ($request->input("sizes")) {
            $sizesNewArray=[];
            $sizesArray=explode(",", $request->sizes);

            foreach ($sizesArray as $size) {
                $sizesNewArray[]=trim($size);
            }

            $sizesNewArray=array_values(array_unique($sizesNewArray));


            foreach ($sizesNewArray as $size) {
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
                        $product->colors()->attach($exisitngSize);
                    }
                }
            }
        }
    }
}
