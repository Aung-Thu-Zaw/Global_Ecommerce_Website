<?php

namespace App\Http\Controllers\Admin\FromTheSubmitters;

use App\Actions\Admin\FromTheSubmitters\Subscribers\PermanentlyDeleteAllTrashSubscriberAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminSubscriberController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $subscribers = Subscriber::search(request('search'))
                                 ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                 ->paginate(request('per_page', 10))
                                 ->appends(request()->all());

        return inertia('Admin/FromTheSubmitters/Subscribers/Index', compact('subscribers'));
    }

    public function destroy(Request $request, Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();

        return to_route('admin.subscribers.index', $this->getQueryStringParams($request))->with('success', 'SUBSCRIBER_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashSubscribers = Subscriber::search(request('search'))
                                      ->onlyTrashed()
                                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                      ->paginate(request('per_page', 10))
                                      ->appends(request()->all());

        return inertia('Admin/FromTheSubmitters/Subscribers/Trash', compact('trashSubscribers'));
    }

    public function restore(Request $request, int $trashSubscriberId): RedirectResponse
    {
        $trashSubscriber = Subscriber::onlyTrashed()->findOrFail($trashSubscriberId);

        $trashSubscriber->restore();

        return to_route('admin.subscribers.trash', $this->getQueryStringParams($request))->with('success', 'SUBSCRIBER_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashSubscriberId): RedirectResponse
    {
        $trashSubscriber = Subscriber::onlyTrashed()->findOrFail($trashSubscriberId);

        $trashSubscriber->forceDelete();

        return to_route('admin.subscribers.trash', $this->getQueryStringParams($request))->with('success', 'THE_SUBSCRIBER_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashSubscribers = Subscriber::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashSubscriberAction())->handle($trashSubscribers);

        return to_route('admin.subscribers.trash', $this->getQueryStringParams($request))->with('success', 'SUBSCRIBERS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
