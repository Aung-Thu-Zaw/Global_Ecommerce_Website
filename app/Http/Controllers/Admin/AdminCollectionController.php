<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Collections\CreateCollectionAction;
use App\Actions\Admin\Collections\PermanentlyDeleteAllTrashCollectionAction;
use App\Actions\Admin\Collections\UpdateCollectionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminCollectionController extends Controller
{
    use HandlesQueryStringParameters;

    public function __construct()
    {
        $this->middleware('permission:collections.view', ['only' => ['index']]);
        $this->middleware('permission:collections.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:collections.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:collections.delete', ['only' => ['destroy', 'destroySelected', 'destroyAll']]);
        $this->middleware('permission:collections.view.trash', ['only' => ['trashed']]);
        $this->middleware('permission:collections.restore', ['only' => ['restore', 'restoreSelected', 'restoreAll']]);
        $this->middleware('permission:collections.force.delete', ['only' => ['forceDelete', 'forceDeleteSelected', 'forceDeleteAll']]);
    }

    public function index(): Response|ResponseFactory
    {
        $collections = Collection::search(request('search'))
                                 ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                 ->paginate(request('per_page', 10))
                                 ->appends(request()->all());

        return inertia('Admin/Collections/Index', compact('collections'));
    }

    public function create(): Response|ResponseFactory
    {
        return inertia('Admin/Collections/Create');
    }

    public function store(CollectionRequest $request): RedirectResponse
    {
        (new CreateCollectionAction())->handle($request->validated());

        return to_route('admin.collections.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully created.');
    }

    public function edit(Request $request, Collection $collection): Response|ResponseFactory
    {
        return inertia('Admin/Collections/Edit', compact('collection'));
    }

    public function update(CollectionRequest $request, Collection $collection): RedirectResponse
    {
        (new UpdateCollectionAction())->handle($request->validated(), $collection);

        return to_route('admin.collections.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully updated.');
    }

    public function destroy(Request $request, Collection $collection): RedirectResponse
    {
        $collection->delete();

        return to_route('admin.collections.index', $this->getQueryStringParams($request))->with('success', ':label has been successfully deleted.');
    }

    public function destroySelected(Request $request): RedirectResponse
    {
        if (! empty($request->selectedItems)) {
            Collection::whereIn('id', $request->selectedItems)->delete();
        }

        return to_route('admin.collections.index', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully deleted.');
    }

    public function destroyAll(Request $request): RedirectResponse
    {
        $collections = Collection::all();

        $collections->each(function ($collection) {
            $collection->delete();
        });

        return to_route('admin.collections.index', $this->getQueryStringParams($request))->with('success', 'All :label have been successfully deleted.');
    }

    public function trashed(): Response|ResponseFactory
    {
        $trashedCollections = Collection::search(request('search'))
                                      ->onlyTrashed()
                                      ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                      ->paginate(request('per_page', 10))
                                      ->appends(request()->all());

        return inertia('Admin/Collections/Trash', compact('trashedCollections'));
    }

    public function restore(Request $request, int $trashCollectionId): RedirectResponse
    {
        $trashCollection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $trashCollection->restore();

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', ':label has been successfully restored.');
    }

    public function restoreSelected(Request $request): RedirectResponse
    {
        if (! empty($request->selectedItems)) {
            Collection::onlyTrashed()->whereIn('id', $request->selectedItems)->restore();
        }

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been successfully restored.');
    }

    public function restoreAll(Request $request): RedirectResponse
    {
        $collections = Collection::onlyTrashed()->get();

        $collections->each(function ($collection) {
            $collection->restore();
        });

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', 'All :label have been successfully restored.');
    }

    public function forceDelete(Request $request, int $trashCollectionId): RedirectResponse
    {
        $trashCollection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $trashCollection->forceDelete();

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', 'The :label has been permanently deleted.');
    }

    public function forceDeleteSelected(Request $request): RedirectResponse
    {
        if (! empty($request->selectedItems)) {
            Collection::onlyTrashed()->whereIn('id', $request->selectedItems)->forceDelete();
        }

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', 'Selected :label have been permanently deleted.');
    }

    public function forceDeleteAll(Request $request): RedirectResponse
    {
        $trashCollections = Collection::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCollectionAction())->handle($trashCollections);

        return to_route('admin.collections.trashed', $this->getQueryStringParams($request))->with('success', 'All :label have been permanently deleted.');
    }
}
