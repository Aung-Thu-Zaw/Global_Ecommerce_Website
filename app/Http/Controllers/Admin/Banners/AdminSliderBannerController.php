<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SliderBannerRequest;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use App\Models\SliderBanner;
use App\Actions\Admin\Banners\SliderBanners\CreateSliderBannerAction;
use App\Actions\Admin\Banners\SliderBanners\PermanentlyDeleteAllTrashSliderBannerAction;
use App\Actions\Admin\Banners\SliderBanners\UpdateSliderBannerAction;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminSliderBannerController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $sliderBanners = SliderBanner::search(request("search"))
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());

        return inertia("Admin/Banners/SliderBanners/Index", compact("sliderBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        return inertia("Admin/Banners/SliderBanners/Create", compact("per_page"));
    }

    public function store(SliderBannerRequest $request): RedirectResponse
    {
        (new CreateSliderBannerAction())->handle($request->validated());

        return to_route("admin.slider-banners.index", $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, SliderBanner $sliderBanner): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/Banners/SliderBanners/Edit", compact("sliderBanner", "queryStringParams"));
    }

    public function update(SliderBannerRequest $request, SliderBanner $sliderBanner): RedirectResponse
    {
        (new UpdateSliderBannerAction())->handle($request->validated(), $sliderBanner);

        return to_route("admin.slider-banners.index", $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, SliderBanner $sliderBanner): RedirectResponse
    {
        $sliderBanner->delete();

        return to_route("admin.slider-banners.index", $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSliderBanners = SliderBanner::search(request("search"))
                                          ->onlyTrashed()
                                          ->orderBy(request("sort", "id"), request("direction", "desc"))
                                          ->paginate(request("per_page", 10))
                                          ->appends(request()->all());

        return inertia("Admin/Banners/SliderBanners/Trash", compact("trashSliderBanners"));
    }

    public function restore(Request $request, int $trashSliderBannerId): RedirectResponse
    {
        $trashSliderBanner = SliderBanner::onlyTrashed()->findOrFail($trashSliderBannerId);

        $trashSliderBanner->restore();

        return to_route('admin.slider-banners.trash', $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashSliderBannerId): RedirectResponse
    {
        $trashSliderBanner = SliderBanner::onlyTrashed()->findOrFail($trashSliderBannerId);

        SliderBanner::deleteImage($trashSliderBanner->image);

        $trashSliderBanner->forceDelete();

        return to_route('admin.slider-banners.trash', $this->getQueryStringParams($request))->with("success", "THE_SLIDER_BANNER_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSliderBanners = SliderBanner::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashSliderBannerAction())->handle($trashSliderBanners);

        return to_route('admin.slider-banners.trash', $this->getQueryStringParams($request))->with("success", "SLIDER_BANNERS_HAVE_BEEN_PERMANENTLY_DELETED");
    }

    public function handleShow(Request $request, int $sliderBannerId): RedirectResponse
    {
        $countsliderBanner = SliderBanner::where("status", "show")->count();

        if ($countsliderBanner >= 6) {

            return to_route('admin.slider-banners.index', $this->getQueryStringParams($request))->with("error", "YOU_CANT_DISPLAY_THE_SLIDER_BANNER");
        }

        $sliderBanner = SliderBanner::where([["id", $sliderBannerId],["status","hide"]])->first();

        if($sliderBanner) {

            $sliderBanner->update(["status" => "show"]);
        }

        return to_route('admin.slider-banners.index', $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_DISPLAYED");
    }

    public function handleHide(Request $request, int $sliderBannerId): RedirectResponse
    {
        $sliderBanner = SliderBanner::where([["id", $sliderBannerId],["status","show"]])->first();

        if($sliderBanner) {

            $sliderBanner->update(["status" => "hide"]);
        }

        return to_route('admin.slider-banners.index', $this->getQueryStringParams($request))->with("success", "SLIDER_BANNER_HAS_BEEN_SUCCESSFULLY_HIDDEN");
    }
}
