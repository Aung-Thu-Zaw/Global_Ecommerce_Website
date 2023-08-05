<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Inertia\Response;
use Inertia\ResponseFactory;

class SearchByCategoryProductController extends Controller
{
    public function show(Category $category): Response|ResponseFactory
    {
        $products=Product::select("id", "user_id", "image", "name", "description", "slug", "price", "discount", "special_offer")
                         ->with(["productReviews:id,product_id,rating","shop:id,offical","images"])
                         ->filterBy(request(["brand","rating","price"]))
                         ->whereStatus("approved")
                         ->whereCategoryId($category->id)
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(20)
                         ->withQueryString();

        $category->load("parent.parent.parent.parent.parent", "children");

        $brands=Brand::where("category_id", $category->id)->get();

        return inertia("Ecommerce/Products/SearchByCategory", compact("category", "brands", "products"));
    }
}
