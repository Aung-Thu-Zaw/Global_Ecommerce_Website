<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderBannerRequest;
use App\Models\SliderBanner;
use App\Services\SliderBannerImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminSliderBannerController extends Controller
{
    public function index()
    {
        $sliderBanners=SliderBanner::search(request("search"))
                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                 ->paginate(request("per_page", 10))
                 ->appends(request()->all());


        return inertia("Admin/Banners/Slider-Banners/Index", compact("sliderBanners"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Slider-Banners/Create", compact("per_page"));
    }

    public function store(SliderBannerRequest $request, SliderBannerImageUploadService $sliderBannerImageUploadService): RedirectResponse
    {
        SliderBanner::create($request->validated()+["image"=>$sliderBannerImageUploadService->createImage($request)]);

        return to_route("admin.slider-banners.index", "per_page=$request->per_page")->with("success", "Slider Banner is created successfully.");
    }

    public function edit(SliderBanner $sliderBanner): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Banners/Slider-Banners/Edit", compact("sliderBanner", "paginate"));
    }

    public function update(SliderBannerRequest $request, SliderBanner $sliderBanner, SliderBannerImageUploadService $sliderBannerImageUploadService): RedirectResponse
    {
        $image=$sliderBannerImageUploadService->updateImage($request, $sliderBanner);

        $sliderBanner->update($request->validated()+["image"=>$image]);

        return to_route("admin.slider-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is updated successfully.");
    }

    public function destroy(Request $request, SliderBanner $sliderBanner): RedirectResponse
    {
        $sliderBanner->delete();

        return to_route("admin.slider-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashSliderBanners=SliderBanner::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Banners/Slider-Banners/Trash", compact("trashSliderBanners"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $sliderBanner = SliderBanner::onlyTrashed()->where("id", $id)->first();

        $sliderBanner->restore();

        return to_route('admin.slider-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $sliderBanner = SliderBanner::onlyTrashed()->where("id", $id)->first();

        SliderBanner::deleteImage($sliderBanner);

        $sliderBanner->forceDelete();

        return to_route('admin.slider-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is deleted successfully");
    }
}
