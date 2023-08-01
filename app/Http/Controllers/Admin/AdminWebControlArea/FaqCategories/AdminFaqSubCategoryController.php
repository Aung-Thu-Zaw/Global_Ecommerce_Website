<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\FaqCategories;

use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\CreateFaqSubCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\PermanentlyDeleteAllTrashFaqSubCategoryAction;
use App\Actions\Admin\AdminWebControlArea\FaqCategories\SubCategories\UpdateFaqSubCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqSubCategoryRequest;
use App\Models\FaqCategory;
use App\Models\FaqSubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminFaqSubCategoryController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $faqSubCategories=FaqSubCategory::search(request("search"))
                                        ->query(function (Builder $builder) {
                                            $builder->with("faqCategory");
                                        })
                                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                                        ->paginate(request("per_page", 10))
                                        ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/FaqCategories/SubCategories/Index", compact("faqSubCategories"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $faqCategories=FaqCategory::all();

        return inertia("Admin/AdminWebControlArea/FaqCategories/SubCategories/Create", compact("per_page", "faqCategories"));
    }

    public function store(FaqSubCategoryRequest $request): RedirectResponse
    {
        (new CreateFaqSubCategoryAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.faq-categories.sub-categories.index", $queryStringParams)->with("success", "Faq Category has been successfully created.");
    }

    public function edit(Request $request, FaqSubCategory $faqSubCategory): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $faqCategories=FaqCategory::all();

        return inertia("Admin/AdminWebControlArea/FaqCategories/SubCategories/Edit", compact("faqSubCategory", "faqCategories", "queryStringParams"));
    }

    public function update(FaqSubCategoryRequest $request, FaqSubCategory $faqSubCategory): RedirectResponse
    {
        (new UpdateFaqSubCategoryAction())->handle($request->validated(), $faqSubCategory);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faq-categories.sub-categories.index", $queryStringParams)->with("success", "Faq Category has been successfully updated.");
    }

    public function destroy(Request $request, FaqSubCategory $faqSubCategory): RedirectResponse
    {
        $faqSubCategory->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faq-categories.sub-categories.index", $queryStringParams)->with("success", "Faq Category has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqSubCategories=FaqSubCategory::search(request("search"))
                                             ->onlyTrashed()
                                             ->orderBy(request("sort", "id"), request("direction", "desc"))
                                             ->paginate(request("per_page", 10))
                                             ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/FaqCategories/SubCategories/Trash", compact("trashFaqSubCategories"));
    }

    public function restore(Request $request, int $trashFaqSubCategoryId): RedirectResponse
    {
        $faqSubCategory = FaqSubCategory::onlyTrashed()->findOrFail($trashFaqSubCategoryId);

        $faqSubCategory->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.sub-categories.trash', $queryStringParams)->with("success", "Faq Category has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashFaqSubCategoryId): RedirectResponse
    {
        $faqSubCategory = FaqSubCategory::onlyTrashed()->findOrFail($trashFaqSubCategoryId);

        $faqSubCategory->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.sub-categories.trash', $queryStringParams)->with("success", "The faq category has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $faqSubCategories = FaqSubCategory::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashFaqSubCategoryAction())->handle($faqSubCategories);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faq-categories.sub-categories.trash', $queryStringParams)->with("success", "Faq Categories have been successfully deleted.");
    }
}
