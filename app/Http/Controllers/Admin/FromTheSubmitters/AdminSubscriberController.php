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

        return to_route("admin.subscribers.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Subscriber has been successfully deleted.");
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

    public function restore(Request $request, int $subscriberId): RedirectResponse
    {

        $subscriber = Subscriber::onlyTrashed()->findOrFail($subscriberId);

        $subscriber->restore();

        return to_route('admin.subscribers.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Subscriber has been successfully restored.");
    }

    public function forceDelete(Request $request, int $subscriberId): RedirectResponse
    {
        $subscriber = Subscriber::onlyTrashed()->findOrFail($subscriberId);

        $subscriber->forceDelete();

        return to_route('admin.subscribers.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The subscriber has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $subscribers = Subscriber::onlyTrashed()->get();

        $subscribers->each(function ($subscriber) {

            $subscriber->forceDelete();

        });

        return to_route('admin.subscribers.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Subscribers have been successfully deleted.");
    }
}
