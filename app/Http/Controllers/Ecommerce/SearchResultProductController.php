<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SearchResultProductController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $products=Product::search(request("search"))->query(function (Builder $builder) {
            $builder->with(["shop","watchlists","cartItems"]);
        })->orderBy(request("sort", "id"), request("direction", "desc"))->paginate(20)->appends(request()->all());

        return inertia("Ecommerce/Products/SearchResult", compact("products"));


        //         $brands=Brand::search(request("search"))
        //         ->query(function (Builder $builder) {
        //             $builder->with("products:id,brand_id,name");
        //         })
        //         ->orderBy(request("sort", "id"), request("direction", "desc"))
        //         ->paginate(request("per_page", 10))
        //         ->appends(request()->all());


        // return inertia("Admin/Brands/Index", compact("brands"));
    }
}
