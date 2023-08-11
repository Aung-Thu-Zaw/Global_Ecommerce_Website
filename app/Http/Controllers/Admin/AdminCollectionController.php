<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Collections\CreateCollectionAction;
use App\Actions\Admin\Collections\PermanentlyDeleteAllTrashCollectionAction;
use App\Actions\Admin\Collections\UpdateCollectionAction;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCollectionController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $collections=Collection::search(request("search"))
                               ->query(function (Builder $builder) {
                                   $builder->with("products:id,collection_id");
                               })
                               ->orderBy(request("sort", "id"), request("direction", "desc"))
                               ->paginate(request("per_page", 10))
                               ->appends(request()->all());

        return inertia("Admin/Collections/Index", compact("collections"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/Collections/Create", compact("per_page"));
    }

    public function store(CollectionRequest $request): RedirectResponse
    {
        (new CreateCollectionAction())->handle($request->validated());

        return to_route("admin.collections.index", $this->getQueryStringParams($request))->with("success", "COLLECTION_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Collection $collection): Response|ResponseFactory
    {
        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/Collections/Edit", compact("collection", "queryStringParams"));
    }

    public function update(CollectionRequest $request, Collection $collection): RedirectResponse
    {
        (new UpdateCollectionAction())->handle($request->validated(), $collection);

        return to_route("admin.collections.index", $this->getQueryStringParams($request))->with("success", "COLLECTION_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Collection $collection): RedirectResponse
    {
        $collection->delete();

        return to_route("admin.collections.index", $this->getQueryStringParams($request))->with("success", "COLLECTION_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCollections=Collection::search(request("search"))
                                    ->onlyTrashed()
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/Collections/Trash", compact("trashCollections"));
    }

    public function restore(Request $request, int $trashCollectionId): RedirectResponse
    {
        $trashCollection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $trashCollection->restore();

        return to_route('admin.collections.trash', $this->getQueryStringParams($request))->with("success", "COLLECTION_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashCollectionId): RedirectResponse
    {
        $trashCollection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $trashCollection->forceDelete();

        return to_route('admin.collections.trash', $this->getQueryStringParams($request))->with("success", "THE_COLLECTION_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCollections = Collection::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCollectionAction())->handle($trashCollections);

        return to_route('admin.collections.trash', $this->getQueryStringParams($request))->with("success", "COLLECTIONS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
