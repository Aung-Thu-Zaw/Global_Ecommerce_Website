<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Services\SliderImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders=Slider::search(request("search"))
                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                 ->paginate(request("per_page", 10))
                 ->appends(request()->all());


        return inertia("Admin/Sliders/Index", compact("sliders"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Sliders/Create", compact("per_page"));
    }

    public function store(SliderRequest $request, SliderImageUploadService $sliderImageUploadService): RedirectResponse
    {
        Slider::create($request->validated()+["image"=>$sliderImageUploadService->createImage($request)]);

        return to_route("admin.sliders.index", "per_page=$request->per_page")->with("success", "Slider is created successfully.");
    }

    public function edit(Slider $slider): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Sliders/Edit", compact("slider", "paginate"));
    }

    public function update(SliderRequest $request, Slider $slider, SliderImageUploadService $sliderImageUploadService): RedirectResponse
    {
        $image=$sliderImageUploadService->updateImage($request, $slider);

        $slider->update($request->validated()+["image"=>$image]);

        return to_route("admin.sliders.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider is updated successfully.");
    }

    public function destroy(Request $request, Slider $slider): RedirectResponse
    {
        $slider->delete();

        return to_route("admin.sliders.index", "page=$request->page&per_page=$request->per_page")->with("success", "Slider is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashSliders=Slider::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Sliders/Trash", compact("trashSliders"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $slider = Slider::onlyTrashed()->where("id", $id)->first();

        $slider->restore();

        return to_route('admin.sliders.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Slider is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $slider = Slider::onlyTrashed()->where("id", $id)->first();

        Slider::deleteImage($slider);

        $slider->forceDelete();

        return to_route('admin.sliders.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Slider is deleted successfully");
    }
}
