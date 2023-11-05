<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories;

use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\CreateFaqSubCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\PermanentlyDeleteAllTrashFaqSubCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\UpdateFaqSubCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqSubCategoryRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\FaqCategory;
use App\Models\FaqSubCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminFaqSubCategoryController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $faqSubCategories = FaqSubCategory::search(request('search'))
                                          ->query(function (Builder $builder) {
                                              $builder->with('faqCategory');
                                          })
                                          ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                          ->paginate(request('per_page', 10))
                                          ->appends(request()->all());

        return inertia('Admin/AdminWebControlArea/FaqCategories/SubCategories/Index', compact('faqSubCategories'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $faqCategories = FaqCategory::all();

        return inertia('Admin/AdminWebControlArea/FaqCategories/SubCategories/Create', compact('per_page', 'faqCategories'));
    }

    public function store(FaqSubCategoryRequest $request): RedirectResponse
    {
        (new CreateFaqSubCategoryAction())->handle($request->validated());

        return to_route('admin.faq-categories.sub-categories.index', $this->getQueryStringParams($request))->with('success', 'FAQ_SUB_CATEGORY_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, FaqSubCategory $faqSubCategory): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $faqCategories = FaqCategory::all();

        return inertia('Admin/AdminWebControlArea/FaqCategories/SubCategories/Edit', compact('faqSubCategory', 'faqCategories', 'queryStringParams'));
    }

    public function update(FaqSubCategoryRequest $request, FaqSubCategory $faqSubCategory): RedirectResponse
    {
        (new UpdateFaqSubCategoryAction())->handle($request->validated(), $faqSubCategory);

        return to_route('admin.faq-categories.sub-categories.index', $this->getQueryStringParams($request))->with('success', 'FAQ_SUB_CATEGORY_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, FaqSubCategory $faqSubCategory): RedirectResponse
    {
        $faqSubCategory->delete();

        return to_route('admin.faq-categories.sub-categories.index', $this->getQueryStringParams($request))->with('success', 'FAQ_SUB_CATEGORY_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqSubCategories = FaqSubCategory::search(request('search'))
                                               ->onlyTrashed()
                                               ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                               ->paginate(request('per_page', 10))
                                               ->appends(request()->all());

        return inertia('Admin/AdminWebControlArea/FaqCategories/SubCategories/Trash', compact('trashFaqSubCategories'));
    }

    public function restore(Request $request, int $trashFaqSubCategoryId): RedirectResponse
    {
        $trashFaqSubCategory = FaqSubCategory::onlyTrashed()->findOrFail($trashFaqSubCategoryId);

        $trashFaqSubCategory->restore();

        return to_route('admin.faq-categories.sub-categories.trash', $this->getQueryStringParams($request))->with('success', 'FAQ_SUB_CATEGORY_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashFaqSubCategoryId): RedirectResponse
    {
        $trashFaqSubCategory = FaqSubCategory::onlyTrashed()->findOrFail($trashFaqSubCategoryId);

        $trashFaqSubCategory->forceDelete();

        return to_route('admin.faq-categories.sub-categories.trash', $this->getQueryStringParams($request))->with('success', 'THE_FAQ_SUB_CATEGORY_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashFaqSubCategories = FaqSubCategory::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashFaqSubCategoryAction())->handle($trashFaqSubCategories);

        return to_route('admin.faq-categories.sub-categories.trash', $this->getQueryStringParams($request))->with('success', 'FAQ_SUB_CATEGORIES_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
