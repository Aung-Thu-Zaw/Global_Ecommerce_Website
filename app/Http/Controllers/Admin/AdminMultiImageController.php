<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;

class AdminMultiImageController extends Controller
{
    public function destroy(int $productId, int $imageId): RedirectResponse
    {
        $image=Image::where([["product_id",$productId],["id",$imageId]])->first();

        Image::deleteImage($image);

        $image->delete();

        return back();
    }
}
