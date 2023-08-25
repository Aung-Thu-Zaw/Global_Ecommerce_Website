<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Actions\Admin\FromTheSubmitters\WebsiteFeedback\PermanentlyDeleteAllTrashWebsiteFeedbackAction;
use App\Http\Controllers\Controller;
use App\Models\WebsiteFeedback;
use Illuminate\Http\RedirectResponse;
use App\Http\Traits\HandlesQueryStringParameters;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminWebsiteFeedbackController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $websiteFeedbacks = WebsiteFeedback::search(request("search"))
                                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                                         ->paginate(request("per_page", 10))
                                         ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Index", compact("websiteFeedbacks"));
    }

    public function show(Request $request, WebsiteFeedback $websiteFeedback): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Detail", compact("websiteFeedback", "queryStringParams"));
    }

    public function destroy(Request $request, WebsiteFeedback $websiteFeedback): RedirectResponse
    {
        $websiteFeedback->delete();

        return to_route("admin.website-feedbacks.index", $this->getQueryStringParams($request))->with("success", "WEBSITE_FEEDBACK_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashWebsiteFeedbacks = WebsiteFeedback::search(request("search"))
                                              ->onlyTrashed()
                                              ->orderBy(request("sort", "id"), request("direction", "desc"))
                                              ->paginate(request("per_page", 10))
                                              ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/WebsiteFeedbacks/Trash", compact("trashWebsiteFeedbacks"));
    }

    public function restore(Request $request, int $trashWebsiteFeedbackId): RedirectResponse
    {
        $trashWebsiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($trashWebsiteFeedbackId);

        $trashWebsiteFeedback->restore();

        return to_route('admin.website-feedbacks.trash', $this->getQueryStringParams($request))->with("success", "WEBSITE_FEEDBACK_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashWebsiteFeedbackId): RedirectResponse
    {
        $trashWebsiteFeedback = WebsiteFeedback::onlyTrashed()->findOrFail($trashWebsiteFeedbackId);

        $trashWebsiteFeedback->forceDelete();

        return to_route('admin.website-feedbacks.trash', $this->getQueryStringParams($request))->with("success", "THE_WEBSITE_FEEDBACK_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashWebsiteFeedbacks = WebsiteFeedback::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashWebsiteFeedbackAction())->handle($trashWebsiteFeedbacks);

        return to_route('admin.website-feedbacks.trash', $this->getQueryStringParams($request))->with("success", "WEBSITE_FEEDBACKS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
