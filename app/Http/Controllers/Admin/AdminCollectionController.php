<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CollectionRequest;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

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
        Collection::create($request->validated());

        return to_route("admin.collections.index", "per_page=$request->per_page")->with("success", "Collection has been successfully created.");
    }

    public function edit(Collection $collection): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/Collections/Edit", compact("collection", "paginate"));
    }

    public function update(CollectionRequest $request, Collection $collection): RedirectResponse
    {
        $collection->update($request->validated());

        return to_route("admin.collections.index", "page=$request->page&per_page=$request->per_page")->with("success", "Collection has been successfully updated.");
    }

    public function destroy(Request $request, Collection $collection): RedirectResponse
    {
        $collection->delete();

        return to_route("admin.collections.index", "page=$request->page&per_page=$request->per_page")->with("success", "Collection has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $collection = Collection::onlyTrashed()->findOrFail($id);

        $collection->restore();

        return to_route('admin.collections.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Collection has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $collection = Collection::onlyTrashed()->findOrFail($id);

        Collection::deleteImage($collection);

        $collection->forceDelete();

        return to_route('admin.collections.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The collection has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $collections = Collection::onlyTrashed()->get();

        $collections->each(function ($collection) {

            Collection::deleteImage($collection);

            $collection->forceDelete();

        });

        return to_route('admin.collections.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Collections have been successfully deleted.");
    }
}
