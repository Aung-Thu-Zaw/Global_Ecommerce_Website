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

        if (!empty($image->img_path) && file_exists(storage_path("app/public/products/$image->img_path"))) {
            unlink(storage_path("app/public/products/$image->img_path"));
        }

        $image->delete();

        return back();
    }
}
