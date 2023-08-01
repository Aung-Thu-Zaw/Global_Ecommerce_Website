<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Collections\CreateCollectionAction;
use App\Actions\Admin\Collections\PermanentlyDeleteAllTrashCollectionAction;
use App\Actions\Admin\Collections\UpdateCollectionAction;
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

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.collections.index", $queryStringParams)->with("success", "Collection has been successfully created.");
    }

    public function edit(Request $request, Collection $collection): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Collections/Edit", compact("collection", "queryStringParams"));
    }

    public function update(CollectionRequest $request, Collection $collection): RedirectResponse
    {
        (new UpdateCollectionAction())->handle($request->validated(), $collection);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.collections.index", $queryStringParams)->with("success", "Collection has been successfully updated.");
    }

    public function destroy(Request $request, Collection $collection): RedirectResponse
    {
        $collection->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.collections.index", $queryStringParams)->with("success", "Collection has been successfully deleted.");
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
        $collection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $collection->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.collections.trash', $queryStringParams)->with("success", "Collection has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashCollectionId): RedirectResponse
    {
        $collection = Collection::onlyTrashed()->findOrFail($trashCollectionId);

        $collection->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.collections.trash', $queryStringParams)->with("success", "The collection has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $collections = Collection::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCollectionAction())->handle($collections);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.collections.trash', $queryStringParams)->with("success", "Collections have been successfully deleted.");
    }
}
