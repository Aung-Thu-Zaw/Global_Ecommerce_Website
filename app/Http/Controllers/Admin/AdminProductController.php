<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(): Response
    {
        $products=Product::search(request("search"))
        ->orderBy(request("sort", "id"), request("direction", "desc"))
        ->paginate(request("per_page", 10))
        ->appends(request()->all());

        return inertia("Admin/Products/Index", compact("products"));
    }
    public function create(): Response
    {
        $per_page=request("per_page");

        $brands=Brand::all();

        $categories=Category::all();

        $subCategories=SubCategory::all();

        $vendors=User::where([["status","active"],["role","vendor"]])->get();

        return inertia("Admin/Products/Create", compact("per_page", "brands", "categories", "subCategories", "vendors"));
    }

    public function store(ProductRequest $request, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        Product::create($request->validated()+["image"=>$categoryImageUploadService->uploadImage($request)]);

        return to_route("admin.products.index", "per_page=$request->per_page")->with("success", "Product is created successfully.");
    }

    public function edit(Product $product): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Products/Edit", compact("product", "paginate"));
    }

    public function update(ProductRequest $request, Product $product, CategoryImageUploadService $categoryImageUploadService): RedirectResponse
    {
        $image=$categoryImageUploadService->updateImage($request, $product);

        $product->update($request->validated()+["image"=>$image]);

        return to_route("admin.products.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product is updated successfully.");
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        return to_route("admin.products.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashProducts=Product::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Products/Trash", compact("trashProducts"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $category = Product::onlyTrashed()->where("id", $id)->first();

        $category->restore();

        return to_route('admin.products.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $category = Product::onlyTrashed()->where("id", $id)->first();

        $category->forceDelete();

        return to_route('admin.products.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product is deleted successfully");
    }
}
