<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Actions\Admin\Categories\CreateCategoryAction;
use App\Actions\Admin\Categories\UpdateCategoryAction;
use App\Actions\Admin\Categories\PermanentlyDeleteAllTrashCategoryAction;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminCategoryController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $categories = Category::search(request("search"))
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
        $per_page = request("per_page");

        $categories = Category::select("id", "parent_id", "name")->get();

        return inertia("Admin/Categories/Create", compact("per_page", "categories"));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        (new CreateCategoryAction())->handle($request->validated());

        return to_route("admin.categories.index", $this->getQueryStringParams($request))->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Category $category): Response|ResponseFactory
    {
        $categories = Category::select("id", "parent_id", "name")->get();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/Categories/Edit", compact("category", "categories", "queryStringParams"));
    }

    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        (new UpdateCategoryAction())->handle($request->validated(), $category);

        return to_route("admin.categories.index", $this->getQueryStringParams($request))->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $category->delete();

        return to_route("admin.categories.index", $this->getQueryStringParams($request))->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashCategories = Category::search(request("search"))
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

        return to_route('admin.categories.trash', $this->getQueryStringParams($request))->with("success", "CATEGORY_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashCategoryId): RedirectResponse
    {
        $trashCategory = Category::onlyTrashed()->findOrFail($trashCategoryId);

        Category::deleteImage($trashCategory->image);

        $trashCategory->forceDelete();

        return to_route('admin.categories.trash', $this->getQueryStringParams($request))->with("success", "THE_CATEGORY_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashCategories = Category::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashCategoryAction())->handle($trashCategories);

        return to_route('admin.categories.trash', $this->getQueryStringParams($request))->with("success", "CATEGORIES_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
