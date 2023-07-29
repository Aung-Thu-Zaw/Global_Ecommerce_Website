<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Products\CreateProductAction;
use App\Actions\Admin\Products\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $products=Product::search(request("search"))
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(request("per_page", 10))
                         ->appends(request()->all());

        return inertia("Admin/Products/Index", compact("products"));
    }

    public function show(Request $request, Product $product): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $product->load("brand:id,name", "shop:id,shop_name", "images", "colors", "sizes");

        return inertia("Admin/Products/Details", compact("product", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $vendors=User::select("id", "name", "shop_name")->where([["status","active"],["role","vendor"]])->get();

        return inertia("Admin/Products/Create", compact("per_page", "brands", "categories", "collections", "vendors"));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        (new CreateProductAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.products.index", $urlStringQuery)->with("success", "Product has been successfully created.");
    }

    public function edit(Request $request, Product $product): Response|ResponseFactory
    {
        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $vendors=User::where([["status","active"],["role","vendor"]])->get();

        $product->load(["sizes","colors","images"]);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Products/Edit", compact("product", "queryStringParams", "brands", "categories", "collections", "vendors"));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        (new UpdateProductAction())->handle($request->validated(), $product);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.products.index", $urlStringQuery)->with("success", "Product has been successfully updated.");
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.products.index", $urlStringQuery)->with("success", "Product has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProducts=Product::search(request("search"))
                              ->onlyTrashed()
                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                              ->paginate(request("per_page", 10))
                              ->appends(request()->all());

        return inertia("Admin/Products/Trash", compact("trashProducts"));
    }

    public function restore(Request $request, int $trashProductId): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($trashProductId);

        $product->restore();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.products.trash', $urlStringQuery)->with("success", "Product has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashProductId): RedirectResponse
    {
        $product = Product::onlyTrashed()->findOrFail($trashProductId);

        $multiImages=Image::where("product_id", $product->id)->get();

        $multiImages->each(function ($image) {

            Image::deleteImage($image);

        });

        Product::deleteImage($product->image);

        $product->forceDelete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.products.trash', $urlStringQuery)->with("success", "Product has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $products = Product::onlyTrashed()->get();

        $products->each(function ($product) {

            $multiImages=Image::where("product_id", $product->id)->get();

            $multiImages->each(function ($image) {

                Image::deleteImage($image);

            });

            Product::deleteImage($product->image);

            $product->forceDelete();

        });

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.products.trash', $urlStringQuery)->with("success", "Products have been successfully deleted.");
    }

    public function handleStatus(Request $request, Product $product): RedirectResponse
    {
        $product->update(["status"=>$request->status]);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        $message=$request->status==="pending" ? "Product has been successfully disapproved" : "Product has been successfully approved";

        return to_route('admin.products.index', $urlStringQuery)->with("success", $message);

    }
}
