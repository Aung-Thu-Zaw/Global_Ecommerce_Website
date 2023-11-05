<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\Faqs;

use App\Actions\Admin\AdminWebControlArea\Faqs\CreateFaqAction;
use App\Actions\Admin\AdminWebControlArea\Faqs\PermanentlyDeleteAllTrashFaqAction;
use App\Actions\Admin\AdminWebControlArea\Faqs\UpdateFaqAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\Faq;
use App\Models\FaqSubCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminFaqController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $faqs = Faq::search(request('search'))
                   ->query(function (Builder $builder) {
                       $builder->with(['faqSubCategory']);
                   })
                   ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                   ->paginate(request('per_page', 10))
                   ->appends(request()->all());

        return inertia('Admin/AdminWebControlArea/Faqs/Index', compact('faqs'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $faqSubCategories = FaqSubCategory::all();

        return inertia('Admin/AdminWebControlArea/Faqs/Create', compact('per_page', 'faqSubCategories'));
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        (new CreateFaqAction())->handle($request->validated());

        return to_route('admin.faqs.index', $this->getQueryStringParams($request))->with('success', 'FAQ_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, Faq $faq): Response|ResponseFactory
    {
        $faqSubCategories = FaqSubCategory::all();

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/AdminWebControlArea/Faqs/Edit', compact('faq', 'faqSubCategories', 'queryStringParams'));
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        (new UpdateFaqAction())->handle($request->validated(), $faq);

        return to_route('admin.faqs.index', $this->getQueryStringParams($request))->with('success', 'FAQ_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, Faq $faq): RedirectResponse
    {
        $faq->delete();

        return to_route('admin.faqs.index', $this->getQueryStringParams($request))->with('success', 'FAQ_HAS_BEEN_SUCCESSFULLY_DELETED');
    }

    public function trash(): Response|ResponseFactory
    {
        $trashFaqs = Faq::search(request('search'))
                        ->query(function (Builder $builder) {
                            $builder->with(['faqSubCategory']);
                        })
                        ->onlyTrashed()
                        ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                        ->paginate(request('per_page', 10))
                        ->appends(request()->all());

        return inertia('Admin/AdminWebControlArea/Faqs/Trash', compact('trashFaqs'));
    }

    public function restore(Request $request, int $trashFaqId): RedirectResponse
    {
        $trashFaq = Faq::onlyTrashed()->findOrFail($trashFaqId);

        $trashFaq->restore();

        return to_route('admin.faqs.trash', $this->getQueryStringParams($request))->with('success', 'FAQ_HAS_BEEN_SUCCESSFULLY_RESTORED');
    }

    public function forceDelete(Request $request, int $trashFaqId): RedirectResponse
    {
        $trashFaq = Faq::onlyTrashed()->findOrFail($trashFaqId);

        $trashFaq->forceDelete();

        return to_route('admin.faqs.trash', $this->getQueryStringParams($request))->with('success', 'THE_FAQ_HAS_BEEN_PERMANENTLY_DELETED');
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashFaqs = Faq::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashFaqAction())->handle($trashFaqs);

        return to_route('admin.faqs.trash', $this->getQueryStringParams($request))->with('success', 'FAQS_HAVE_BEEN_PERMANENTLY_DELETED');
    }
}
