<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderBannerRequest;
use App\Models\SliderBanner;
use App\Services\SliderBannerImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminSliderBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $sliderBanners=SliderBanner::search(request("search"))
                                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                                     ->paginate(request("per_page", 10))
                                     ->appends(request()->all());


        return inertia("Admin/Banners/Slider-Banners/Index", compact("sliderBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Slider-Banners/Create", compact("per_page"));
    }

    public function store(SliderBannerRequest $request, SliderBannerImageUploadService $sliderBannerImageUploadService): RedirectResponse
    {
        SliderBanner::create($request->validated()+["image"=>$sliderBannerImageUploadService->createImage($request),"status"=>"hide"]);

        return to_route("admin.slider-banners.index", "per_page=$request->per_page")->with("success", "Slider Banner is created successfully.");
    }

    public function edit(SliderBanner $sliderBanner): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Banners/Slider-Banners/Edit", compact("sliderBanner", "paginate"));
    }

    public function update(SliderBannerRequest $request, SliderBanner $sliderBanner, SliderBannerImageUploadService $sliderBannerImageUploadService): RedirectResponse
    {
        $sliderBanner->update($request->validated()+["image"=>$sliderBannerImageUploadService->updateImage($request, $sliderBanner),"status"=>$sliderBanner->status]);

        return to_route("admin.slider-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is updated successfully.");
    }

    public function destroy(Request $request, SliderBanner $sliderBanner): RedirectResponse
    {
        $sliderBanner->delete();

        return to_route("admin.slider-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is deleted successfully.");
    }

    public function trash(): Response|ResponseFactory
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

    public function handleShow(Request $request, int $id): RedirectResponse
    {
        $countsliderBanner=SliderBanner::where("status", "show")->count();

        if ($countsliderBanner >= 4) {
            return to_route('admin.slider-banners.index', "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is cannot bla bla show successfully");
        }

        $sliderBanner = SliderBanner::where([["id", $id],["status","hide"]])->first();

        $sliderBanner->update(["status"=>"show"]);

        return to_route('admin.slider-banners.index', "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is show successfully");
    }

    public function handleHide(Request $request, int $id): RedirectResponse
    {
        $sliderBanner = SliderBanner::where([["id", $id],["status","show"]])->first();

        $sliderBanner->update(["status"=>"hide"]);

        return to_route('admin.slider-banners.index', "page=$request->page&per_page=$request->per_page")->with("success", "Slider Banner is hide successfully");
    }
}
