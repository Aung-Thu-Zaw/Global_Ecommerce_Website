<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Details", compact("websiteFeedback", "paginate"));
    }

    public function destroy(Request $request, WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback->delete();

        return to_route("admin.website-feedbacks.index", "page=$request->page&per_page=$request->per_page")->with("success", "Website Feedback has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {

        dd("hit");
        $trashWebsiteFeedbacks=WebsiteFeedback::search(request("search"))
                                              ->onlyTrashed()
                                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                                              ->paginate(request("per_page", 10))
                                              ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Trash", compact("trashWebsiteFeedbacks"));
    }

    public function restore(Request $request, WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->where("id", $websiteFeedback->id)->first();

        $websiteFeedback->restore();

        return to_route('admin.website-feedbacks.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Website Feedback has been successfully restored.");
    }

    public function forceDelete(Request $request, WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback = WebsiteFeedback::onlyTrashed()->where("id", $websiteFeedback->id)->first();

        $websiteFeedback->forceDelete();

        return to_route('admin.website-feedbacks.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Website Feedback has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $websiteFeedbacks = WebsiteFeedback::onlyTrashed()->get();

        $websiteFeedbacks->each(function ($websiteFeedback) {

            $websiteFeedback->forceDelete();

        });
        return to_route('admin.website-feedbacks.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Website Feedbacks have been successfully deleted.");
    }
}
