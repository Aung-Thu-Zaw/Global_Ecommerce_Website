<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignBannerRequest;
use App\Models\CampaignBanner;
use App\Services\CampaignBannerImageUploadService;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminCampaignBannerController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $campaignBanners=CampaignBanner::search(request("search"))
                                       ->orderBy(request("sort", "id"), request("direction", "desc"))
                                       ->paginate(request("per_page", 10))
                                       ->appends(request()->all());


        return inertia("Admin/Banners/Campaign-Banners/Index", compact("campaignBanners"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Banners/Campaign-Banners/Create", compact("per_page"));
    }

    public function store(CampaignBannerRequest $request, CampaignBannerImageUploadService $campaignBannerImageUploadService): RedirectResponse
    {
        CampaignBanner::create($request->validated()+["status"=>"hide","image"=>$campaignBannerImageUploadService->createImage($request)]);

        return to_route("admin.campaign-banners.index", "per_page=$request->per_page")->with("success", "Campaign Banner has been successfully created.");
    }

    public function edit(CampaignBanner $campaignBanner): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Banners/Campaign-Banners/Edit", compact("campaignBanner", "paginate"));
    }

    public function update(CampaignBannerRequest $request, CampaignBanner $campaignBanner, CampaignBannerImageUploadService $campaignBannerImageUploadService): RedirectResponse
    {
        $campaignBanner->update($request->validated()+["status"=>$campaignBanner->status,"image"=>$campaignBannerImageUploadService->updateImage($request, $campaignBanner)]);

        return to_route("admin.campaign-banners.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Campaign Banner has been successfully updated.");
    }

    public function destroy(Request $request, CampaignBanner $campaignBanner): RedirectResponse
    {
        $campaignBanner->delete();

        return to_route("admin.campaign-banners.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Campaign Banner has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
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
        $campaignBanner = CampaignBanner::onlyTrashed()->findOrFail($id);

        $campaignBanner->restore();

        return to_route('admin.campaign-banners.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Campaign Banner has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $campaignBanner = CampaignBanner::onlyTrashed()->findOrFail($id);

        CampaignBanner::deleteImage($campaignBanner);

        $campaignBanner->forceDelete();

        return to_route('admin.campaign-banners.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Campaign Banner has been permanently deleted.");
    }

    public function handleShow(Request $request, int $id): RedirectResponse
    {
        DB::table("campaign_banners")->update(["status"=>"hide"]);

        $campaignBanner = CampaignBanner::where([["id", $id],["status","hide"]])->first();

        if($campaignBanner) {
            $campaignBanner->update(["status"=>"show"]);
        }

        return to_route('admin.campaign-banners.index', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The campaign banner has been successfully displayed.");
    }

    public function handleHide(Request $request, int $id): RedirectResponse
    {
        $campaignBanner = CampaignBanner::where([["id", $id],["status","show"]])->first();

        if($campaignBanner) {
            $campaignBanner->update(["status"=>"hide"]);
        }

        return to_route('admin.campaign-banners.index', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The campaign banner has been successfully hidden.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $campaignBanners = CampaignBanner::onlyTrashed()->get();

        $campaignBanners->each(function ($campaignBanner) {
            CampaignBanner::deleteImage($campaignBanner);
            $campaignBanner->forceDelete();
        });

        return to_route('admin.campaign-banners.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Campaign Banners have been successfully deleted.");
    }
}
