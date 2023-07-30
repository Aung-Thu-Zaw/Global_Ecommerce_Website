<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories;

use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\CreateFaqCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\Categories\UpdateFaqCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\Category;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminFaqCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $faqCategories=FaqCategory::search(request("search"))
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
        $per_page=request("per_page");

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Create", compact("per_page"));
    }

    public function store(FaqCategoryRequest $request): RedirectResponse
    {
        (new CreateFaqCategoryAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.faq-categories.categories.index", $queryStringParams)->with("success", "Faq Category has been successfully created.");
    }

    public function edit(Request $request, FaqCategory $faqCategory): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Edit", compact("faqCategory", "queryStringParams"));
    }

    public function update(FaqCategoryRequest $request, FaqCategory $faqCategory): RedirectResponse
    {
        (new UpdateFaqCategoryAction())->handle($request->validated(), $faqCategory);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faq-categories.categories.index", $queryStringParams)->with("success", "Faq Category has been successfully updated.");
    }

    public function destroy(Request $request, FaqCategory $faqCategory): RedirectResponse
    {
        $faqCategory->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faq-categories.categories.index", $queryStringParams)->with("success", "Faq Category has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqCategories=Category::search(request("search"))
                                 ->onlyTrashed()
                                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                                 ->paginate(request("per_page", 10))
                                 ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/FaqCategories/Categories/Trash", compact("trashFaqCategories"));
    }

    public function restore(Request $request, int $trashFaqCategoryId): RedirectResponse
    {
        $faqCategory = FaqCategory::onlyTrashed()->findOrFail($trashFaqCategoryId);

        $faqCategory->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.categories.trash', $queryStringParams)->with("success", "Faq Category has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashFaqCategoryId): RedirectResponse
    {
        $faqCategory = FaqCategory::onlyTrashed()->findOrFail($trashFaqCategoryId);

        $faqCategory->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.categories.trash', $queryStringParams)->with("success", "The faq category has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $faqCategories = FaqCategory::onlyTrashed()->get();

        $faqCategories->each(function ($faqCategory) {

            $faqCategory->forceDelete();

        });

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.categories.trash', $queryStringParams)->with("success", "Faq Categories have been successfully deleted.");
    }
}
