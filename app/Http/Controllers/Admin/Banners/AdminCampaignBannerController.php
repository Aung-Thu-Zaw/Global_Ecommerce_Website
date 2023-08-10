<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Actions\Admin\Banners\CampaignBanners\CreateCampaignBannerAction;
use App\Actions\Admin\Banners\CampaignBanners\PermanentlyDeleteAllTrashCampaignBannerAction;
use App\Actions\Admin\Banners\CampaignBanners\UpdateCampaignBannerAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignBannerRequest;
use App\Models\CampaignBanner;
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

    public function store(CampaignBannerRequest $request): RedirectResponse
    {
        (new CreateCampaignBannerAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.campaign-banners.index", $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_CREATED"));
    }

    public function edit(Request $request, CampaignBanner $campaignBanner): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Banners/Campaign-Banners/Edit", compact("campaignBanner", "queryStringParams"));
    }

    public function update(CampaignBannerRequest $request, CampaignBanner $campaignBanner): RedirectResponse
    {
        (new UpdateCampaignBannerAction())->handle($request->validated(), $campaignBanner);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.campaign-banners.index", $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_UPDATED"));
    }

    public function destroy(Request $request, CampaignBanner $campaignBanner): RedirectResponse
    {
        $campaignBanner->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.campaign-banners.index", $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_DELETED"));
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

    public function restore(Request $request, int $trashCampaignBannerId): RedirectResponse
    {
        $campaignBanner = CampaignBanner::onlyTrashed()->findOrFail($trashCampaignBannerId);

        $campaignBanner->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.campaign-banners.trash', $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_RESTORED"));
    }

    public function forceDelete(Request $request, int $trashCampaignBannerId): RedirectResponse
    {
        $trashCampaignBanner = CampaignBanner::onlyTrashed()->findOrFail($trashCampaignBannerId);

        CampaignBanner::deleteImage($trashCampaignBanner->image);

        $trashCampaignBanner->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.campaign-banners.trash', $queryStringParams)->with("success", __("THE_CAMPAIGN_BANNER_HAS_BEEN_PERMANENTLY_DELETED"));
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCampaignBanners = CampaignBanner::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCampaignBannerAction())->handle($trashCampaignBanners);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.campaign-banners.trash', $queryStringParams)->with("success", __("CAMPAIGN_BANNERS_HAVE_BEEN_PERMANENTLY_DELETED"));
    }

    public function handleShow(Request $request, int $campaignBannerId): RedirectResponse
    {
        DB::table("campaign_banners")->update(["status"=>"hide"]);

        $campaignBanner = CampaignBanner::where([["id", $campaignBannerId],["status","hide"]])->first();

        if($campaignBanner) {

            $campaignBanner->update(["status"=>"show"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.campaign-banners.index', $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_DISPLAYED"));
    }

    public function handleHide(Request $request, int $campaignBannerId): RedirectResponse
    {
        $campaignBanner = CampaignBanner::where([["id", $campaignBannerId],["status","show"]])->first();

        if($campaignBanner) {

            $campaignBanner->update(["status"=>"hide"]);
        }

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.campaign-banners.index', $queryStringParams)->with("success", __("CAMPAIGN_BANNER_HAS_BEEN_SUCCESSFULLY_HIDDEN"));
    }

}
