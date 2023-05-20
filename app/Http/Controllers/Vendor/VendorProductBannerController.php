<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductBannerRequest;
use App\Models\ProductBanner;
use App\Services\ProductBannerImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;

class VendorProductBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $productBanners=ProductBanner::search(request("search"))
                                       ->where("user_id", auth()->user()->id)
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->appends(request()->all());

        return inertia("Vendor/Product-Banners/Index", compact("productBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Vendor/Product-Banners/Create", compact("per_page"));
    }

    public function store(ProductBannerRequest $request, ProductBannerImageUploadService $productBannerImageUploadService): RedirectResponse
    {
        ProductBanner::create($request->validated()+["image"=>$productBannerImageUploadService->createImage($request),"status"=>"hide"]);

        return to_route("vendor.product-banners.index", "per_page=$request->per_page")->with("success", "Product Banner has been successfully created.");
    }

    public function edit(ProductBanner $productBanner): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Vendor/Product-Banners/Edit", compact("productBanner", "paginate"));
    }

    public function update(ProductBannerRequest $request, ProductBanner $productBanner, ProductBannerImageUploadService $productBannerImageUploadService): RedirectResponse
    {
        $productBanner->update($request->validated()+["image"=>$productBannerImageUploadService->updateImage($request, $productBanner),"status"=>$productBanner->status]);

        return to_route("vendor.product-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been successfully updated.");
    }

    public function destroy(Request $request, ProductBanner $productBanner): RedirectResponse
    {
        $productBanner->delete();

        return to_route("vendor.product-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProductBanners=ProductBanner::search(request("search"))
                                            ->onlyTrashed()
                                            ->where("user_id", auth()->user()->id)
                                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                                            ->paginate(request("per_page", 10))
                                            ->appends(request()->all());

        return inertia("Vendor/Product-Banners/Trash", compact("trashProductBanners"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->where("id", $id)->first();

        $productBanner->restore();

        return to_route('vendor.product-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->where("id", $id)->first();

        ProductBanner::deleteImage($productBanner);

        $productBanner->forceDelete();

        return to_route('vendor.product-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been permanently deleted.");
    }

    public function handleShow(Request $request, int $id): RedirectResponse
    {
        $countProductBanners=ProductBanner::where([["user_id", auth()->user()->id ],["status", "show"]])->count();

        if ($countProductBanners >= 6) {
            return to_route('vendor.product-banners.index', "page=$request->page&per_page=$request->per_page")->with("error", "You can't display the product banner. Only 6 product banners are allowed.");
        }

        $productBanner = ProductBanner::where([["id", $id],["status","hide"]])->first();

        $productBanner->update(["status"=>"show"]);

        return to_route('vendor.product-banners.index', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been successfully displayed.");
    }

    public function handleHide(Request $request, int $id): RedirectResponse
    {
        $productBanner = ProductBanner::where([["id", $id],["status","show"]])->first();

        $productBanner->update(["status"=>"hide"]);

        return to_route('vendor.product-banners.index', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banner has been successfully hidden.");
    }


    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $productBanners = ProductBanner::onlyTrashed()->where("user_id", auth()->user()->id)->get();

        $productBanners->each(function ($productBanner) {
            ProductBanner::deleteImage($productBanner);
            $productBanner->forceDelete();
        });

        return to_route('vendor.product-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Product Banners have been successfully deleted.");
    }
}
