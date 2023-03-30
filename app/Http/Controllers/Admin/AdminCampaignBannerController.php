<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignBannerRequest;
use App\Models\CampaignBanner;
use App\Services\CampaignBannerImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminCampaignBannerController extends Controller
{
    public function index()
    {
        $campaignBanners=CampaignBanner::search(request("search"))
                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                 ->paginate(request("per_page", 10))
                 ->appends(request()->all());


        return inertia("Admin/Banners/Campaign-Banners/Index", compact("campaignBanners"));
    }

    public function create(): Response
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Campaign-Banners/Create", compact("per_page"));
    }

    public function store(CampaignBannerRequest $request, CampaignBannerImageUploadService $campaignBannerImageUploadService): RedirectResponse
    {
        CampaignBanner::create($request->validated()+["image"=>$campaignBannerImageUploadService->createImage($request)]);

        return to_route("admin.campaign-banners.index", "per_page=$request->per_page")->with("success", "Campaign Banner is created successfully.");
    }

    public function edit(CampaignBanner $campaignBanner): Response
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Banners/Campaign-Banners/Edit", compact("campaignBanner", "paginate"));
    }

    public function update(CampaignBannerRequest $request, CampaignBanner $campaignBanner, CampaignBannerImageUploadService $campaignBannerImageUploadService): RedirectResponse
    {
        $image=$campaignBannerImageUploadService->updateImage($request, $campaignBanner);

        $campaignBanner->update($request->validated()+["image"=>$image]);

        return to_route("admin.campaign-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Campaign Banner is updated successfully.");
    }

    public function destroy(Request $request, CampaignBanner $campaignBanner): RedirectResponse
    {
        $campaignBanner->delete();

        return to_route("admin.campaign-banners.index", "page=$request->page&per_page=$request->per_page")->with("success", "Campaign Banner is deleted successfully.");
    }

    public function trash(): Response
    {
        $trashCampaignBanners=CampaignBanner::search(request("search"))
                                ->onlyTrashed()
                                ->orderBy(request("sort", "id"), request("direction", "desc"))
                                ->paginate(request("per_page", 10))
                                ->appends(request()->all());

        return inertia("Admin/Banners/Campaign-Banners/Trash", compact("trashCampaignBanners"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $campaignBanner = CampaignBanner::onlyTrashed()->where("id", $id)->first();

        $campaignBanner->restore();

        return to_route('admin.campaign-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Campaign Banner is restored successfully.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $campaignBanner = CampaignBanner::onlyTrashed()->where("id", $id)->first();

        CampaignBanner::deleteImage($campaignBanner);

        $campaignBanner->forceDelete();

        return to_route('admin.campaign-banners.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Campaign Banner is deleted successfully");
    }
}
