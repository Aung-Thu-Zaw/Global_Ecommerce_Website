<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Categories\CreateCategoryAction;
use App\Actions\Admin\Categories\UpdateCategoryAction;
use App\Actions\Admin\Categories\PermanentlyDeleteAllTrashCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $categories=Category::search(request("search"))
                            ->query(function (Builder $builder) {
                                $builder->with("children");
                            })
                            ->orderBy(request("sort", "id"), request("direction", "desc"))
                            ->paginate(request("per_page", 10))
                            ->appends(request()->all());

        return inertia("Admin/Categories/Index", compact("categories"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $categories=Category::select("id", "parent_id", "name")->get();

        return inertia("Admin/Categories/Create", compact("per_page", "categories"));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        (new CreateCategoryAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.categories.index", $queryStringParams)->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Category $category): Response|ResponseFactory
    {
        $categories=Category::select("id", "parent_id", "name")->get();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/Categories/Edit", compact("category", "categories", "queryStringParams"));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        (new UpdateCategoryAction())->handle($request->validated(), $category);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.categories.index", $queryStringParams)->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.categories.index", $queryStringParams)->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCategories=Category::search(request("search"))
                                 ->onlyTrashed()
                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                 ->paginate(request("per_page", 10))
                                 ->appends(request()->all());

        return inertia("Admin/Categories/Trash", compact("trashCategories"));
    }

    public function restore(Request $request, int $trashCategoryId): RedirectResponse
    {
        $trashCategory = Category::onlyTrashed()->findOrFail($trashCategoryId);

        $trashCategory->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.categories.trash', $queryStringParams)->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashCategoryId): RedirectResponse
    {
        $trashCategory = Category::onlyTrashed()->findOrFail($trashCategoryId);

        Category::deleteImage($trashCategory->image);

        $trashCategory->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.categories.trash', $queryStringParams)->with("success", "THE_CATEGORY_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCategories = Category::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCategoryAction())->handle($trashCategories);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.categories.trash', $queryStringParams)->with("success", "CATEGORIES_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
