<?php

namespace App\Http\Controllers\Vendor;

use App\Actions\Vendor\ProductBanners\CreateVendorProductBannerAction;
use App\Actions\Vendor\ProductBanners\PermanentlyDeleteAllTrashVendorProductBannerAction;
use App\Actions\Vendor\ProductBanners\UpdateVendorProductBannerAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\VendorProductBannerRequest;
use App\Models\VendorProductBanner;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;

class VendorProductBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $vendorProductBanners=VendorProductBanner::search(request("search"))
                                                 ->where("user_id", auth()->id())
                                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                 ->paginate(request("per_page", 10))
                                                 ->appends(request()->all());

        return inertia("Vendor/ProductBanners/Index", compact("vendorProductBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Vendor/ProductBanners/Create", compact("per_page"));
    }

    public function store(VendorProductBannerRequest $request): RedirectResponse
    {
        (new CreateVendorProductBannerAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("vendor.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully created.");

    }

    public function edit(Request $request, VendorProductBanner $vendorProductBanner): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Vendor/Product-Banners/Edit", compact("vendorProductBanner", "queryStringParams"));
    }

    public function update(VendorProductBannerRequest $request, VendorProductBanner $vendorProductBanner): RedirectResponse
    {
        (new UpdateVendorProductBannerAction())->handle($request->validated(), $vendorProductBanner);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("vendor.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully updated.");
    }

    public function destroy(Request $request, VendorProductBanner $vendorProductBanner): RedirectResponse
    {
        $vendorProductBanner->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("vendor.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashVendorProductBanners=VendorProductBanner::search(request("search"))
                                                      ->onlyTrashed()
                                                      ->where("user_id", auth()->id())
                                                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                      ->paginate(request("per_page", 10))
                                                      ->appends(request()->all());

        return inertia("Vendor/ProductBanners/Trash", compact("trashVendorProductBanners"));
    }

    public function restore(Request $request, int $trashVendorProductBannerId): RedirectResponse
    {
        $vendorProductBanner = VendorProductBanner::onlyTrashed()->findOrFail($trashVendorProductBannerId);

        $vendorProductBanner->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('vendor.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashVendorProductBannerId): RedirectResponse
    {
        $vendorProductBanner = VendorProductBanner::onlyTrashed()->findOrFail($trashVendorProductBannerId);

        VendorProductBanner::deleteImage($vendorProductBanner->image);

        $vendorProductBanner->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('vendor.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been permanently deleted.");
    }

    public function handleShow(Request $request, int $vendorProductBannerId): RedirectResponse
    {
        $countVendorProductBanners=VendorProductBanner::where([["user_id", auth()->id() ],["status", "show"]])->count();

        if ($countVendorProductBanners >= 6) {

            $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

            return to_route('vendor.product-banners.index', $queryStringParams)->with("error", "You can't display the product banner. Only 6 product banners are allowed.");
        }

        $vendorProductBanner = VendorProductBanner::where([["id", $vendorProductBannerId],["status","hide"]])->first();

        if($vendorProductBanner) {

            $vendorProductBanner->update(["status"=>"show"]);

        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('vendor.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully displayed.");

    }

    public function handleHide(Request $request, int $vendorProductBannerId): RedirectResponse
    {
        $vendorProductBanner = VendorProductBanner::where([["id", $vendorProductBannerId],["status","show"]])->first();

        if($vendorProductBanner) {

            $vendorProductBanner->update(["status"=>"hide"]);
        }


        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('vendor.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully hidden.");

    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $vendorProductBanners = VendorProductBanner::onlyTrashed()->where("user_id", auth()->id())->get();

        (new PermanentlyDeleteAllTrashVendorProductBannerAction())->handle($vendorProductBanners);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('vendor.product-banners.trash', $queryStringParams)->with("success", "Product Banners have been successfully deleted.");
    }
}
