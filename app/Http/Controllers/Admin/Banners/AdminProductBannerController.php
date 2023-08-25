<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductBannerRequest;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;
use App\Models\ProductBanner;
use App\Actions\Admin\Banners\ProductBanners\CreateProductBannerAction;
use App\Actions\Admin\Banners\ProductBanners\PermanentlyDeleteAllTrashProductBannerAction;
use App\Actions\Admin\Banners\ProductBanners\UpdateProductBannerAction;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminProductBannerController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $productBanners = ProductBanner::search(request("search"))
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->appends(request()->all());

        return inertia("Admin/Banners/Product-Banners/Index", compact("productBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        return inertia("Admin/Banners/Product-Banners/Create", compact("per_page"));
    }

    public function store(ProductBannerRequest $request): RedirectResponse
    {
        (new CreateProductBannerAction())->handle($request->validated());

        return to_route("admin.product-banners.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, ProductBanner $productBanner): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/Banners/Product-Banners/Edit", compact("productBanner", "queryStringParams"));
    }

    public function update(ProductBannerRequest $request, ProductBanner $productBanner): RedirectResponse
    {
        (new UpdateProductBannerAction())->handle($request->validated(), $productBanner);

        return to_route("admin.product-banners.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, ProductBanner $productBanner): RedirectResponse
    {
        $productBanner->delete();

        return to_route("admin.product-banners.index", $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashProductBanners = ProductBanner::search(request("search"))
                                            ->onlyTrashed()
                                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                                            ->paginate(request("per_page", 10))
                                            ->appends(request()->all());

        return inertia("Admin/Banners/Product-Banners/Trash", compact("trashProductBanners"));
    }

    public function restore(Request $request, int $trashProductBannerId): RedirectResponse
    {
        $trashProductBanner = ProductBanner::onlyTrashed()->findOrFail($trashProductBannerId);

        $trashProductBanner->restore();

        return to_route('admin.product-banners.trash', $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashProductBannerId): RedirectResponse
    {
        $trashProductBanner = ProductBanner::onlyTrashed()->findOrFail($trashProductBannerId);

        ProductBanner::deleteImage($trashProductBanner->image);

        $trashProductBanner->forceDelete();

        return to_route('admin.product-banners.trash', $this->getQueryStringParams($request))->with("success", "THE_PRODUCT_BANNER_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashProductBanners = ProductBanner::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashProductBannerAction())->handle($trashProductBanners);

        return to_route('admin.product-banners.trash', $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNERS_HAVE_BEEN_PERMANENTLY_DELETED");
    }

    public function handleShow(Request $request, int $productBannerId): RedirectResponse
    {
        $countProductBanners = ProductBanner::where("status", "show")->count();

        if ($countProductBanners >= 3) {

            return to_route('admin.product-banners.index', $this->getQueryStringParams($request))->with("error", "YOU_CANT_DISPLAY_THE_PRODUCT_BANNER");
        }

        $productBanner = ProductBanner::where([["id", $productBannerId],["status","hide"]])->first();

        if($productBanner) {

            $productBanner->update(["status" => "show"]);
        }

        return to_route('admin.product-banners.index', $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_DISPLAYED");
    }

    public function handleHide(Request $request, int $productBannerId): RedirectResponse
    {
        $productBanner = ProductBanner::where([["id", $productBannerId],["status","show"]])->first();

        if($productBanner) {

            $productBanner->update(["status" => "hide"]);
        }

        return to_route('admin.product-banners.index', $this->getQueryStringParams($request))->with("success", "PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_HIDDEN");
    }

}
