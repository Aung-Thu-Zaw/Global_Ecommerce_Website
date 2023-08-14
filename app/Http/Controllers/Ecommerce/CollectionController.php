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
        $collections=Collection::select("id", "title", "slug")->with(["products:id,collection_id,image,status"])->paginate(20);

        return inertia("Ecommerce/Collections/Index", compact("collections"));
    }

    public function show(Collection $collection): Response|ResponseFactory
    {
        $products=Product::select("id", "seller_id", "image", "name", "slug", "price", "discount", "special_offer")
                         ->with(["productReviews:id,product_id,rating","shop:id,offical"])
                         ->whereStatus("approved")
                         ->whereCollectionId($collection->id)
                         ->paginate(20);

        return inertia("Ecommerce/Collections/Show", compact("products", "collection"));
    }
}
