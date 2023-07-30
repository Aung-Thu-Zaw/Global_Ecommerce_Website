<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Actions\Admin\Banners\ProductBanners\CreateProductBannerAction;
use App\Actions\Admin\Banners\ProductBanners\UpdateProductBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductBannerRequest;
use App\Models\ProductBanner;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;

class AdminProductBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $productBanners=ProductBanner::search(request("search"))
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());

        return inertia("Admin/Banners/Product-Banners/Index", compact("productBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Product-Banners/Create", compact("per_page"));
    }

    public function store(ProductBannerRequest $request): RedirectResponse
    {
        (new CreateProductBannerAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully created.");
    }

    public function edit(Request $request, ProductBanner $productBanner): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Banners/Product-Banners/Edit", compact("productBanner", "queryStringParams"));
    }

    public function update(ProductBannerRequest $request, ProductBanner $productBanner): RedirectResponse
    {
        (new UpdateProductBannerAction())->handle($request->validated(), $productBanner);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully updated.");
    }

    public function destroy(Request $request, ProductBanner $productBanner): RedirectResponse
    {
        $productBanner->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProductBanners=ProductBanner::search(request("search"))
                                          ->onlyTrashed()
                                          ->orderBy(request("sort", "id"), request("direction", "desc"))
                                          ->paginate(request("per_page", 10))
                                          ->appends(request()->all());

        return inertia("Admin/Banners/Product-Banners/Trash", compact("trashProductBanners"));
    }

    public function restore(Request $request, int $trashProductBannerId): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->findOrFail($trashProductBannerId);

        $productBanner->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashProductBannerId): RedirectResponse
    {
        $productBanner = ProductBanner::onlyTrashed()->findOrFail($trashProductBannerId);

        ProductBanner::deleteImage($productBanner->image);

        $productBanner->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been permanently deleted.");
    }

    public function handleShow(Request $request, int $productBannerId): RedirectResponse
    {
        $countProductBanners=ProductBanner::where("status", "show")->count();

        if ($countProductBanners >= 3) {

            $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

            return to_route('admin.product-banners.index', $queryStringParams)->with("error", "You can't display the product banner. Only 3 product banners are allowed.");

        }

        $productBanner = ProductBanner::where([["id", $productBannerId],["status","hide"]])->first();

        if($productBanner) {

            $productBanner->update(["status"=>"show"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully displayed.");
    }

    public function handleHide(Request $request, int $productBannerId): RedirectResponse
    {
        $productBanner = ProductBanner::where([["id", $productBannerId],["status","show"]])->first();

        if($productBanner) {

            $productBanner->update(["status"=>"hide"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully hidden.");
    }


    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $productBanners = ProductBanner::onlyTrashed()->get();

        $productBanners->each(function ($productBanner) {

            ProductBanner::deleteImage($productBanner->image);

            $productBanner->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.product-banners.trash', $queryStringParams)->with("success", "Product Banners have been successfully deleted.");
    }
}
