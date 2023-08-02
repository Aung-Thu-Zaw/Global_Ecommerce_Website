<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\Faqs;

use App\Actions\Admin\AdminWebControlArea\Faqs\CreateFaqAction;
use App\Actions\Admin\AdminWebControlArea\Faqs\PermanentlyDeleteAllTrashFaqAction;
use App\Actions\Admin\AdminWebControlArea\Faqs\UpdateFaqAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Models\Faq;
use App\Models\FaqSubCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;

class AdminFaqController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $faqs=Faq::search(request("search"))
                 ->query(function (Builder $builder) {
                     $builder->with(["faqSubCategory"]);
                 })
                 ->orderBy(request("sort", "id"), request("direction", "desc"))
                 ->paginate(request("per_page", 10))
                 ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/Faqs/Index", compact("faqs"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $faqSubCategories=FaqSubCategory::all();

        return inertia("Admin/AdminWebControlArea/Faqs/Create", compact("per_page", "faqSubCategories"));
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        (new CreateFaqAction())->handle($request->validated());

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.faqs.index", $queryStringParams)->with("success", "Faq has been successfully created.");
    }

    public function edit(Request $request, Faq $faq): Response|ResponseFactory
    {
        $faqSubCategories=FaqSubCategory::all();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/AdminWebControlArea/Faqs/Edit", compact("faq", "faqSubCategories", "queryStringParams"));
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        (new UpdateFaqAction())->handle($request->validated(), $faq);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faqs.index", $queryStringParams)->with("success", "Faq has been successfully updated.");
    }

    public function destroy(Request $request, Faq $faq): RedirectResponse
    {
        $faq->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.faqs.index", $queryStringParams)->with("success", "Faq has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqs=Faq::search(request("search"))
                      ->query(function (Builder $builder) {
                          $builder->with(["faqSubCategory"]);
                      })
                      ->onlyTrashed()
                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                      ->paginate(request("per_page", 10))
                      ->appends(request()->all());

        return inertia("Admin/AdminWebControlArea/Faqs/Trash", compact("trashFaqs"));
    }

    public function restore(Request $request, int $trashFaqId): RedirectResponse
    {
        $faq = Faq::onlyTrashed()->findOrFail($trashFaqId);

        $faq->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faqs.trash', $queryStringParams)->with("success", "Faq has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashFaqId): RedirectResponse
    {
        $faq = Faq::onlyTrashed()->findOrFail($trashFaqId);

        $faq->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faqs.trash', $queryStringParams)->with("success", "The faq has been permanently deleted.");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $faqs = Faq::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashFaqAction())->handle($faqs);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.faqs.trash', $queryStringParams)->with("success", "Faq Categories have been successfully deleted.");
    }
}
