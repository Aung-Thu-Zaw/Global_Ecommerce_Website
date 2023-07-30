<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function show(Request $request, WebsiteFeedback $websiteFeedback): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Details", compact("websiteFeedback", "queryStringParams"));
    }

    public function destroy(Request $request, WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.website-feedbacks.index", $queryStringParams)->with("success", "Website Feedback has been successfully deleted.");
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

    public function restore(Request $request, int $trashWebsiteFeedbackId): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($trashWebsiteFeedbackId);

        $websiteFeedback->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.website-feedbacks.trash', $queryStringParams)->with("success", "Website Feedback has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashWebsiteFeedbackId): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($trashWebsiteFeedbackId);

        $websiteFeedback->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.website-feedbacks.trash', $queryStringParams)->with("success", "Website Feedback has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $websiteFeedbacks = WebsiteFeedback::onlyTrashed()->get();

        $websiteFeedbacks->each(function ($websiteFeedback) {

            $websiteFeedback->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.website-feedbacks.trash', $queryStringParams)->with("success", "Website Feedbacks have been successfully deleted.");
    }
}
