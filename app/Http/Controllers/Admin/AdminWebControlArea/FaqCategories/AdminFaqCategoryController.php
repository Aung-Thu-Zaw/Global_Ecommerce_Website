<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\FaqCategory;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\CreateFaqCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\PermanentlyDeleteAllTrashFaqCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\UpdateFaqCategoryAction;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminFaqCategoryController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $faqCategories = FaqCategory::search(request("search"))
                                    ->query(function (Builder $builder) {
                                        $builder->with("faqSubCategories");
                                    })
                                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                                    ->paginate(request("per_page", 10))
                                    ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Index", compact("faqCategories"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Create", compact("per_page"));
    }

    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        (new CreateFaqCategoryAction())->handle($request->validated());

        return to_route("admin.faq-categories.categories.index", $this->getQueryStringParams($request))->with("success", "FAQ_CATEGORY_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, FaqCategory $faqCategory): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Edit", compact("faqCategory", "queryStringParams"));
    }

    public function update(FaqCategoryRequest $request, FaqCategory $faqCategory): RedirectResponse
    {
        (new UpdateFaqCategoryAction())->handle($request->validated(), $faqCategory);

        return to_route("admin.faq-categories.categories.index", $this->getQueryStringParams($request))->with("success", "FAQ_CATEGORY_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, FaqCategory $faqCategory): RedirectResponse
    {
        $faqCategory->delete();

        return to_route("admin.faq-categories.categories.index", $this->getQueryStringParams($request))->with("success", "FAQ_CATEGORY_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqCategories = FaqCategory::search(request("search"))
                                         ->onlyTrashed()
                                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                                         ->paginate(request("per_page", 10))
                                         ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Trash", compact("trashFaqCategories"));
    }

    public function restore(Request $request, int $trashFaqCategoryId): RedirectResponse
    {
        $trashFaqCategory = FaqCategory::onlyTrashed()->findOrFail($trashFaqCategoryId);

        $trashFaqCategory->restore();

        return to_route('admin.faq-categories.categories.trash', $this->getQueryStringParams($request))->with("success", "FAQ_CATEGORY_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashFaqCategoryId): RedirectResponse
    {
        $trashFaqCategory = FaqCategory::onlyTrashed()->findOrFail($trashFaqCategoryId);

        $trashFaqCategory->forceDelete();

        return to_route('admin.faq-categories.categories.trash', $this->getQueryStringParams($request))->with("success", "THE_FAQ_CATEGORY_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashFaqCategories = FaqCategory::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashFaqCategoryAction())->handle($trashFaqCategories);

        return to_route('admin.faq-categories.categories.trash', $this->getQueryStringParams($request))->with("success", "FAQ_CATEGORIES_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
