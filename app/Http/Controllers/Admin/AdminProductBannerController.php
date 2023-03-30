<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductBannerRequest;
use App\Models\ProductBanner;
use App\Services\ProductBannerImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminProductBannerController extends Controller
{
    public function index()
    {
        $productBanners=ProductBanner::search(request("search"))
                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                 ->paginate(request("per_page", 10))
                 ->appends(request()->all());


        return inertia("Admin/Banners/Product-Banners/Index", compact("productBanners"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Product-Banners/Create", compact("per_page"));
    }

    public function store(ProductBannerRequest $request, ProductBannerImageUploadService $productBannerImageUploadService): RedirectResponse
    {
        ProductBanner::create($request->validated()+["image"=>$productBannerImageUploadService->createImage($request)]);

        return to_route("admin.product-banners.index", "per_page=$request->per_page")->with("success", "Product Banner is created successfully.");
    }

    public function edit(ProductBanner $productBanner): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Banners/Product-Banners/Edit", compact("productBanner", "paginate"));
    }

    public function update(ProductBannerRequest $request, ProductBanner $productBanner, ProductBannerImageUploadService $productBannerImageUploadService): RedirectResponse
    {
        $image=$productBannerImageUploadService->updateImage($request, $productBanner);

        $productBanner->update($request->validated()+["image"=>$image]);

        return to_route("admin.product-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner is updated successfully.");
    }

    public function destroy(Request $request, ProductBanner $productBanner): RedirectResponse
    {
        $productBanner->delete();

        return to_route("admin.product-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashProductBanners=ProductBanner::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Banners/Product-Banners/Trash", compact("trashProductBanners"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->where("id", $id)->first();

        $productBanner->restore();

        return to_route('admin.product-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->where("id", $id)->first();

        ProductBanner::deleteImage($productBanner);

        $productBanner->forceDelete();

        return to_route('admin.product-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner is deleted successfully");
    }
}
