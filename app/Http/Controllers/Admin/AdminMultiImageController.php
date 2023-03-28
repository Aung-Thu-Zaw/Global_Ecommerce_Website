<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class AdminMultiImageController extends Controller
{
    public function destroy($productId, $imageId)
    {
        $image=Image::where([["product_id",$productId],["id",$imageId]])->first();

        Image::deleteImage($image);

        $image->delete();

        return back();
    }
}
