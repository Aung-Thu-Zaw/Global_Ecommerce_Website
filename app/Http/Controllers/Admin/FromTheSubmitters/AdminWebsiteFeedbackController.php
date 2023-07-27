<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminWebsiteFeedbackController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $websiteFeedbacks=WebsiteFeedback::search(request("search"))
                                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                                         ->paginate(request("per_page", 10))
                                         ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Index", compact("websiteFeedbacks"));
    }

    public function show(WebsiteFeedback $websiteFeedback): Response|ResponseFactory
    {
        $queryParameters=["page"=>request("page"),"per_page"=>request("per_page"),"sort"=>request("sort"),"direction"=>request("direction")];

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Details", compact("websiteFeedback", "queryParameters"));
    }

    public function destroy(WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback->delete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route("admin.website-feedbacks.index", $urlStringQuery)->with("success", "Website Feedback has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashWebsiteFeedbacks=WebsiteFeedback::search(request("search"))
                                              ->onlyTrashed()
                                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                                              ->paginate(request("per_page", 10))
                                              ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Trash", compact("trashWebsiteFeedbacks"));
    }

    public function restore(int $websiteFeedbackId): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($websiteFeedbackId);

        $websiteFeedback->restore();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.website-feedbacks.trash', $urlStringQuery)->with("success", "Website Feedback has been successfully restored.");
    }

    public function forceDelete(int $websiteFeedbackId): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($websiteFeedbackId);

        $websiteFeedback->forceDelete();

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.website-feedbacks.trash', $urlStringQuery)->with("success", "Website Feedback has been permanently deleted.");
    }

    public function permanentlyDelete(): RedirectResponse
    {
        $websiteFeedbacks = WebsiteFeedback::onlyTrashed()->get();

        $websiteFeedbacks->each(function ($websiteFeedback) {

            $websiteFeedback->forceDelete();

        });

        $urlStringQuery="page=".request("page")."&per_page=".request("per_page")."&sort=".request("sort")."&direction=".request("direction");

        return to_route('admin.website-feedbacks.trash', $urlStringQuery)->with("success", "Website Feedbacks have been successfully deleted.");
    }
}
