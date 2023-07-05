<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SearchHistory;
use Inertia\Response;
use Inertia\ResponseFactory;

class SearchResultProductController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        SearchHistory::firstOrCreate(
            ["user_id"=>auth()->user()->id,"keyword"=>request("search")],
            ["user_id"=>auth()->user()->id,"keyword"=>request("search")]
        );

        $products=Product::select("id", "user_id", "image", "name", "description", "slug", "price", "discount", "special_offer")
                         ->with(["productReviews:id,product_id,rating","shop:id,offical","images"])
                         ->filterBy(request(["search","category","brand","rating","price"]))
                         ->whereStatus("active")
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(20)
                         ->appends(request()->all());

        $categories=Category::all();

        $brands=null;

        if(request("category")) {
            $category=Category::where("slug", request("category"))->first();

            $brands=Brand::where("category_id", $category->id)->get();
        } else {
            $brands=Brand::all();
        }

        return inertia("Ecommerce/Products/SearchResult", compact("categories", "brands", "products"));
    }
}
