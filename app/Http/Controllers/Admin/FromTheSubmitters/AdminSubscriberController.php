<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminSubscriberController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $subscribers=Subscriber::search(request("search"))
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(request("per_page", 10))
                               ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/Subscribers/Index", compact("subscribers"));
    }

    public function destroy(Request $request, Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.subscribers.index", $queryStringParams)->with("success", "Subscriber has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSubscribers=Subscriber::search(request("search"))
                                    ->onlyTrashed()
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/FromTheSubmitters/Subscribers/Trash", compact("trashSubscribers"));
    }

    public function restore(Request $request, int $trashSubscriberId): RedirectResponse
    {
        $subscriber = Subscriber::onlyTrashed()->findOrFail($trashSubscriberId);

        $subscriber->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.subscribers.trash', $queryStringParams)->with("success", "Subscriber has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashSubscriberId): RedirectResponse
    {
        $subscriber = Subscriber::onlyTrashed()->findOrFail($trashSubscriberId);

        $subscriber->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.subscribers.trash', $queryStringParams)->with("success", "The subscriber has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $subscribers = Subscriber::onlyTrashed()->get();

        $subscribers->each(function ($subscriber) {

            $subscriber->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.subscribers.trash', $queryStringParams)->with("success", "Subscribers have been successfully deleted.");
    }
}
