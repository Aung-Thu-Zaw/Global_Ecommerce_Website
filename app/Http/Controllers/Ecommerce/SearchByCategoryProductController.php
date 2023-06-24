<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SearchByCategoryProductController extends Controller
{
    public function show(Category $category): Response|ResponseFactory
    {
        $products=Product::with(["category","shop","watchlists","cartItems","images"])
                        ->filterBy(request(["brand","rating","price"]))
                        ->where([["category_id",$category->id],["status", "active"]])
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(20)
                        ->appends(request()->all());

        $category->load("parent.parent.parent.parent.parent", "children");

        $brands=Brand::where("category_id", $category->id)->get();

        return inertia("Ecommerce/Products/SearchByCategory", compact("category", "brands", "products"));

    }
}
