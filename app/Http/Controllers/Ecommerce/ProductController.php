<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Product;
use Inertia\Response;
use Inertia\ResponseFactory;

class ProductController extends Controller
{
    public function newProducts(): Response|ResponseFactory
    {
        $newProducts= Product::where("status", "active")->whereBetween('created_at', [now()->subDays(30), now()])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/NewProducts", compact("newProducts"));
    }

    public function featuredProducts(): Response|ResponseFactory
    {
        $featuredProducts=Product::where([["status", "active"],["featured",1]])->orderBy("id", "desc")->paginate(20);

        return inertia("Ecommerce/Products/FeaturedProducts", compact("featuredProducts"));
    }


    public function show(Product $product): Response|ResponseFactory
    {
        $images=Image::where("product_id", $product->id)->get();

        return inertia("Ecommerce/Products/Detail", compact("product", "images"));
    }
}
