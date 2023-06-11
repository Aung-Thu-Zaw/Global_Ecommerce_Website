<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CreateProductColorAction;
use App\Actions\CreateProductSizeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Image;
use App\Models\Product;
use App\Models\User;
use App\Services\ProductImageUploadService;
use App\Services\ProductMultiImageUploadService;
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

    public function show(Product $product): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $product->load("brand:id,name", "shop:id,shop_name", "images");

        return inertia("Admin/Products/Details", compact("product", "paginate"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $vendors=User::where([["status","active"],["role","vendor"]])->get();

        return inertia("Admin/Products/Create", compact("per_page", "brands", "categories", "collections", "vendors"));
    }

    public function store(ProductRequest $request, ProductImageUploadService $productImageUploadService, ProductMultiImageUploadService $productMultiImageUploadService): RedirectResponse
    {
        $product= Product::create($request->validated()+["image"=>$productImageUploadService->createImage($request)]);

        (new CreateProductSizeAction())->handle($request, $product);

        (new CreateProductColorAction())->handle($request, $product);

        $productMultiImageUploadService->createMultiImage($request, $product);

        return to_route("admin.products.index", "per_page=$request->per_page")->with("success", "Product has been successfully created.");
    }

    public function edit(Product $product): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $brands=Brand::all();

        $categories=Category::all();

        $collections=Collection::all();

        $vendors=User::where([["status","active"],["role","vendor"]])->get();

        $product->load(["sizes","colors","images"]);

        return inertia("Admin/Products/Edit", compact("product", "paginate", "brands", "categories", "collections", "vendors"));
    }

    public function update(ProductRequest $request, Product $product, ProductImageUploadService $productImageUploadService, ProductMultiImageUploadService $productMultiImageUploadService): RedirectResponse
    {
        $product->update($request->validated()+["image"=>$productImageUploadService->updateImage($request, $product)]);

        (new CreateProductSizeAction())->handle($request, $product);

        (new CreateProductColorAction())->handle($request, $product);

        $productMultiImageUploadService->createMultiImage($request, $product);

        return to_route("admin.products.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product has been successfully updated.");
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $product->delete();

        return to_route("admin.products.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->where("id", $id)->first();

        $product->restore();

        return to_route('admin.products.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $product = Product::onlyTrashed()->where("id", $id)->first();

        $multiImages=Image::where("product_id", $product->id)->get();

        $multiImages->each(function ($image) {
            Image::deleteImage($image);
        });

        Product::deleteImage($product);

        $product->forceDelete();

        return to_route('admin.products.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $products = Product::onlyTrashed()->get();

        $products->each(function ($product) {
            Product::deleteImage($product);
            $product->forceDelete();
        });

        return to_route('admin.products.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Products have been successfully deleted.");
    }
}
