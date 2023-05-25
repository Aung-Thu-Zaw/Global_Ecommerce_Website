<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;

class SearchResultProductController extends Controller
{
    public function index(): Response|ResponseFactory
    {







        $products=Product::with(["shop","watchlists","cartItems","images"])
                        ->filterBy(request(["search","category","brand","rating","price"]))
                        ->where("status", "active")
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(20)
                        ->appends(request()->all());

        $categories=Category::all();

        $brands=Brand::all();

        return inertia("Ecommerce/Products/SearchResult", compact("categories", "brands", "products"));

    }
}
