<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\Products\CreateProductAction;
use App\Actions\Seller\Products\PermanentlyDeleteAllTrashProductAction;
use App\Actions\Seller\Products\PermanentlyDeleteTrashProductAction;
use App\Actions\Seller\Products\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Services\BroadcastNotifications\SellerCreatesANewProductNotificationSendToAdminDashboardService;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $products=Product::search(request("search"))
                         ->where("seller_id", auth()->id())
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(request("per_page", 10))
                         ->appends(request()->all());

        return inertia("Seller/Products/Index", compact("products"));
    }

    public function show(Request $request, Product $product): Response|ResponseFactory
    {
        $product->load("brand:id,name", "shop:id,shop_name", "images", "colors", "sizes", "types");

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Seller/Products/Details", compact("product", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $brands=Brand::all();

        $categories=Category::all();

        return inertia("Seller/Products/Create", compact("per_page", "brands", "categories"));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $product=(new CreateProductAction())->handle($request->validated());

        (new SellerCreatesANewProductNotificationSendToAdminDashboardService())->send($product);

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("seller.products.index", $queryStringParams)->with("success", "Product has been successfully created.");
    }

    public function edit(Request $request, Product $product): Response|ResponseFactory
    {
        $brands=Brand::all();

        $categories=Category::all();

        $product->load(["sizes","colors","types","images"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Seller/Products/Edit", compact("product", "queryStringParams", "brands", "categories"));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        (new UpdateProductAction())->handle($request->validated(), $product);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("seller.products.index", $queryStringParams)->with("success", "Product has been successfully updated.");
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("seller.products.index", $queryStringParams)->with("success", "Product has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProducts=Product::search(request("search"))
                              ->onlyTrashed()
                              ->where("seller_id", auth()->id())
                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                              ->paginate(request("per_page", 10))
                              ->appends(request()->all());

        return inertia("Seller/Products/Trash", compact("trashProducts"));
    }

    public function restore(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        $trashProduct->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.products.trash', $queryStringParams)->with("success", "Product has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashProductId): RedirectResponse
    {
        $trashProduct = Product::onlyTrashed()->findOrFail($trashProductId);

        (new PermanentlyDeleteTrashProductAction())->handle($trashProduct);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.products.trash', $queryStringParams)->with("success", "Product has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashProducts = Product::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductAction())->handle($trashProducts);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.products.trash', $queryStringParams)->with("success", "Products have been successfully deleted.");
    }
}
