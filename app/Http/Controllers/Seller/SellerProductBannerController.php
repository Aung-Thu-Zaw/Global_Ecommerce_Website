<?php

namespace App\Http\Controllers\Seller;

use App\Actions\Seller\ProductBanners\CreateSellerProductBannerAction;
use App\Actions\Seller\ProductBanners\PermanentlyDeleteAllTrashSellerProductBannerAction;
use App\Actions\Seller\ProductBanners\UpdateSellerProductBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SellerProductBannerRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\SellerProductBanner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class SellerProductBannerController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $sellerProductBanners = SellerProductBanner::search(request('search'))
                                                   ->where('seller_id', auth()->id())
                                                   ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                                   ->paginate(request('per_page', 10))
                                                   ->appends(request()->all());

        return inertia('Seller/ProductBanners/Index', compact('sellerProductBanners'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        return inertia('Seller/ProductBanners/Create', compact('per_page'));
    }

    public function store(SellerProductBannerRequest $request): RedirectResponse
    {
        (new CreateSellerProductBannerAction())->handle($request->validated());

        return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, SellerProductBanner $sellerProductBanner): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Seller/ProductBanners/Edit', compact('sellerProductBanner', 'queryStringParams'));
    }

    public function update(SellerProductBannerRequest $request, SellerProductBanner $sellerProductBanner): RedirectResponse
    {
        (new UpdateSellerProductBannerAction())->handle($request->validated(), $sellerProductBanner);

        return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, SellerProductBanner $sellerProductBanner): RedirectResponse
    {
        $sellerProductBanner->delete();

        return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSellerProductBanners = SellerProductBanner::search(request('search'))
                                                        ->onlyTrashed()
                                                        ->where('seller_id', auth()->id())
                                                        ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                                        ->paginate(request('per_page', 10))
                                                        ->appends(request()->all());

        return inertia('Seller/ProductBanners/Trash', compact('trashSellerProductBanners'));
    }

    public function restore(Request $request, int $trashSellerProductBannerId): RedirectResponse
    {
        $trashSellerProductBanner = SellerProductBanner::onlyTrashed()->findOrFail($trashSellerProductBannerId);

        $trashSellerProductBanner->restore();

        return to_route('seller.product-banners.trash', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashSellerProductBannerId): RedirectResponse
    {
        $trashSellerProductBanner = SellerProductBanner::onlyTrashed()->findOrFail($trashSellerProductBannerId);

        SellerProductBanner::deleteImage($trashSellerProductBanner->image);

        $trashSellerProductBanner->forceDelete();

        return to_route('seller.product-banners.trash', $this->getQueryStringParams($request))->with('success', 'THE_PRODUCT_BANNER_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $sellerProductBanners = SellerProductBanner::onlyTrashed()->where('seller_id', auth()->id())->get();

        (new PermanentlyDeleteAllTrashSellerProductBannerAction())->handle($sellerProductBanners);

        return to_route('seller.product-banners.trash', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNERS_HAVE_BEEN_PERMANENTLY_DELETED');
    }

    public function handleShow(Request $request, int $sellerProductBannerId): RedirectResponse
    {
        $countSellerProductBanners = SellerProductBanner::where([['seller_id', auth()->id()], ['status', 'show']])->count();

        if ($countSellerProductBanners >= 6) {
            return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('error', 'YOU_CANT_DISPLAY_THE_SELLER_PRODUCT_BANNER');
        }

        $sellerProductBanner = SellerProductBanner::where([['id', $sellerProductBannerId], ['status', 'hide']])->first();

        if ($sellerProductBanner) {
            $sellerProductBanner->update(['status' => 'show']);
        }

        return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_DISPLAYED');
    }

    public function handleHide(Request $request, int $sellerProductBannerId): RedirectResponse
    {
        $sellerProductBanner = SellerProductBanner::where([['id', $sellerProductBannerId], ['status', 'show']])->first();

        if ($sellerProductBanner) {
            $sellerProductBanner->update(['status' => 'hide']);
        }

        return to_route('seller.product-banners.index', $this->getQueryStringParams($request))->with('success', 'PRODUCT_BANNER_HAS_BEEN_SUCCESSFULLY_HIDDEN');
    }
}
