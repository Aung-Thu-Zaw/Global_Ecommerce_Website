<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\RedirectResponse;

class MultiImageController extends Controller
{
    public function destroy(int $productId, int $imageId): RedirectResponse
    {
        $image=Image::where([["product_id",$productId],["id",$imageId]])->first();

        Image::deleteImage($image);

        $image->delete();

        return back();
    }
}
