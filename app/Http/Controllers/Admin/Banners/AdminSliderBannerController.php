<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Actions\Admin\Banners\SliderBanners\CreateSliderBannerAction;
use App\Actions\Admin\Banners\SliderBanners\PermanentlyDeleteAllTrashSliderBannerAction;
use App\Actions\Admin\Banners\SliderBanners\UpdateSliderBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderBannerRequest;
use App\Models\SliderBanner;
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

    public function store(SliderBannerRequest $request): RedirectResponse
    {
        (new CreateSliderBannerAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.slider-banners.index", $queryStringParams)->with("success", "Slider Banner has been successfully created.");
    }

    public function edit(Request $request, SliderBanner $sliderBanner): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Banners/Slider-Banners/Edit", compact("sliderBanner", "queryStringParams"));
    }

    public function update(SliderBannerRequest $request, SliderBanner $sliderBanner): RedirectResponse
    {
        (new UpdateSliderBannerAction())->handle($request->validated(), $sliderBanner);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.slider-banners.index", $queryStringParams)->with("success", "Slider Banner has been successfully updated.");
    }

    public function destroy(Request $request, SliderBanner $sliderBanner): RedirectResponse
    {
        $sliderBanner->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.slider-banners.index", $queryStringParams)->with("success", "Slider Banner has been successfully deleted.");
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

    public function restore(Request $request, int $trashSliderBannerId): RedirectResponse
    {
        $trashSliderBanner = SliderBanner::onlyTrashed()->findOrFail($trashSliderBannerId);

        $trashSliderBanner->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.slider-banners.trash', $queryStringParams)->with("success", "Slider Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashSliderBannerId): RedirectResponse
    {
        $trashSliderBanner = SliderBanner::onlyTrashed()->findOrFail($trashSliderBannerId);

        SliderBanner::deleteImage($trashSliderBanner->image);

        $trashSliderBanner->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.slider-banners.trash', $queryStringParams)->with("success", "Slider Banner has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSliderBanners = SliderBanner::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashSliderBannerAction())->handle($trashSliderBanners);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.slider-banners.trash', $queryStringParams)->with("success", "Slider Banners have been successfully deleted.");
    }

    public function handleShow(Request $request, int $sliderBannerId): RedirectResponse
    {
        $countsliderBanner=SliderBanner::where("status", "show")->count();

        if ($countsliderBanner >= 6) {

            $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

            return to_route('admin.slider-banners.index', $queryStringParams)->with("error", "You can't display the slider banner. Only 6 slider banners are allowed.");
        }

        $sliderBanner = SliderBanner::where([["id", $sliderBannerId],["status","hide"]])->first();

        if($sliderBanner) {

            $sliderBanner->update(["status"=>"show"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.slider-banners.index', $queryStringParams)->with("success", "Slider Banner has been successfully displayed.");
    }

    public function handleHide(Request $request, int $sliderBannerId): RedirectResponse
    {
        $sliderBanner = SliderBanner::where([["id", $sliderBannerId],["status","show"]])->first();

        if($sliderBanner) {

            $sliderBanner->update(["status"=>"hide"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.slider-banners.index', $queryStringParams)->with("success", "Slider Banner has been successfully hidden.");
    }


}
