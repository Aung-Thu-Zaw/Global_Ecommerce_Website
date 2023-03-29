<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Services\BannerImageUploadService;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminBannerController extends Controller
{
    // public function index()
    // {
    //     $banners=Banner::search(request("search"))
    //              ->orderBy(request("sort", "id"), request("direction", "desc"))
    //              ->paginate(request("per_page", 10))
    //              ->appends(request()->all());


    //     return inertia("Admin/Banners/Index", compact("banners"));
    // }

    // public function create(): Response
    // {
    //     $per_page=request("per_page");

    //     return inertia("Admin/Banners/Create", compact("per_page"));
    // }

    // public function store(BannerRequest $request, BannerImageUploadService $bannerImageUploadService): RedirectResponse
    // {
    //     Banner::create($request->validated()+["image"=>$bannerImageUploadService->createImage($request)]);

    //     return to_route("admin.banners.index", "per_page=$request->per_page")->with("success", "Banner is created successfully.");
    // }

    // public function edit(Banner $banner): Response
    // {
    //     $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

    //     return inertia("Admin/Banners/Edit", compact("banner", "paginate"));
    // }

    // public function update(BannerRequest $request, Banner $banner, BannerImageUploadService $bannerImageUploadService): RedirectResponse
    // {
    //     $image=$bannerImageUploadService->updateImage($request, $banner);

    //     $banner->update($request->validated()+["image"=>$image]);

    //     return to_route("admin.banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Banner is updated successfully.");
    // }

    // public function destroy(Request $request, Banner $banner): RedirectResponse
    // {
    //     $banner->delete();

    //     return to_route("admin.banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Banner is deleted successfully.");
    // }

    // public function trash(): Response
    // {
    //     $trashBanners=Banner::search(request("search"))
    //                             ->onlyTrashed()
    //                             ->orderBy(request("sort", "id"), request("direction", "desc"))
    //                             ->paginate(request("per_page", 10))
    //                             ->appends(request()->all());

    //     return inertia("Admin/Banners/Trash", compact("trashBanners"));
    // }

    // public function restore(Request $request, int $id): RedirectResponse
    // {
    //     $banner = Banner::onlyTrashed()->where("id", $id)->first();

    //     $banner->restore();

    //     return to_route('admin.banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Banner is restored successfully.");
    // }

    // public function forceDelete(Request $request, int $id): RedirectResponse
    // {
    //     $banner = Banner::onlyTrashed()->where("id", $id)->first();

    //     Banner::deleteImage($banner);

    //     $banner->forceDelete();

    //     return to_route('admin.banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Banner is deleted successfully");
    // }
}
