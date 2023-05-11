<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Product;
use Inertia\Response;
use Inertia\ResponseFactory;

class CollectionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $collections=Collection::with(["products:id,collection_id,image"])->paginate(20);

        return inertia("Ecommerce/Collections/Index", compact("collections"));
    }

    public function show(Collection $collection): Response|ResponseFactory
    {
        $products=Product::with(["shop","watchlists","cartItems"])
                         ->where("collection_id", $collection->id)
                         ->paginate(20);

        return inertia("Ecommerce/Collections/Show", compact("products", "collection"));
    }
}
