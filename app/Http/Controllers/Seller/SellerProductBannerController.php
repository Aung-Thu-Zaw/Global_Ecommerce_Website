<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\ProductBanners\CreateSellerProductBannerAction;
use App\Actions\Seller\ProductBanners\PermanentlyDeleteAllTrashSellerProductBannerAction;
use App\Actions\Seller\ProductBanners\UpdateSellerProductBannerAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SellerProductBannerRequest;
use App\Models\SellerProductBanner;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;

class SellerProductBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $sellerProductBanners=SellerProductBanner::search(request("search"))
                                                 ->where("seller_id", auth()->id())
                                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                 ->paginate(request("per_page", 10))
                                                 ->appends(request()->all());

        return inertia("Seller/ProductBanners/Index", compact("sellerProductBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Seller/ProductBanners/Create", compact("per_page"));
    }

    public function store(SellerProductBannerRequest $request): RedirectResponse
    {
        (new CreateSellerProductBannerAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("seller.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully created.");
    }

    public function edit(Request $request, SellerProductBanner $sellerProductBanner): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Seller/ProductBanners/Edit", compact("sellerProductBanner", "queryStringParams"));
    }

    public function update(SellerProductBannerRequest $request, SellerProductBanner $sellerProductBanner): RedirectResponse
    {
        (new UpdateSellerProductBannerAction())->handle($request->validated(), $sellerProductBanner);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("seller.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully updated.");
    }

    public function destroy(Request $request, SellerProductBanner $sellerProductBanner): RedirectResponse
    {
        $sellerProductBanner->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("seller.product-banners.index", $queryStringParams)->with("success", "Product Banner has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSellerProductBanners=SellerProductBanner::search(request("search"))
                                                      ->onlyTrashed()
                                                      ->where("seller_id", auth()->id())
                                                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                                                      ->paginate(request("per_page", 10))
                                                      ->appends(request()->all());

        return inertia("Seller/ProductBanners/Trash", compact("trashSellerProductBanners"));
    }

    public function restore(Request $request, int $trashSellerProductBannerId): RedirectResponse
    {
        $sellerProductBanner = SellerProductBanner::onlyTrashed()->findOrFail($trashSellerProductBannerId);

        $sellerProductBanner->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashSellerProductBannerId): RedirectResponse
    {
        $sellerProductBanner = SellerProductBanner::onlyTrashed()->findOrFail($trashSellerProductBannerId);

        SellerProductBanner::deleteImage($sellerProductBanner->image);

        $sellerProductBanner->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.product-banners.trash', $queryStringParams)->with("success", "Product Banner has been permanently deleted.");
    }

    public function handleShow(Request $request, int $sellerProductBannerId): RedirectResponse
    {
        $countSellerProductBanners=SellerProductBanner::where([["seller_id", auth()->id() ],["status", "show"]])->count();

        if ($countSellerProductBanners >= 6) {

            $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

            return to_route('seller.product-banners.index', $queryStringParams)->with("error", "You can't display the product banner. Only 6 product banners are allowed.");
        }

        $sellerProductBanner = SellerProductBanner::where([["id", $sellerProductBannerId],["status","hide"]])->first();

        if($sellerProductBanner) {

            $sellerProductBanner->update(["status"=>"show"]);

        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully displayed.");

    }

    public function handleHide(Request $request, int $sellerProductBannerId): RedirectResponse
    {
        $sellerProductBanner = SellerProductBanner::where([["id", $sellerProductBannerId],["status","show"]])->first();

        if($sellerProductBanner) {

            $sellerProductBanner->update(["status"=>"hide"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.product-banners.index', $queryStringParams)->with("success", "Product Banner has been successfully hidden.");

    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $sellerProductBanners = SellerProductBanner::onlyTrashed()->where("seller_id", auth()->id())->get();

        (new PermanentlyDeleteAllTrashSellerProductBannerAction())->handle($sellerProductBanners);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('seller.product-banners.trash', $queryStringParams)->with("success", "Product Banners have been successfully deleted.");
    }
}
