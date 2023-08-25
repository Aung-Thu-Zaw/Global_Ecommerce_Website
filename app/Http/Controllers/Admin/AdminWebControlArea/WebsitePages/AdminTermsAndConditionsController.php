<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\ResponseFactory;
use App\Models\Page;
use App\Http\Requests\TermsAndConditionsRequest;
use App\Actions\Admin\AdminWebControlArea\WebsitePages\TermsAndConditions\UpdateTermsAndConditionsAction;

class AdminTermsAndConditionsController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $termsAndConditions = Page::findOrFail(2);

        return inertia("Admin/AdminWebControlArea/WebsitePages/TermsAndConditions/Edit", compact("termsAndConditions"));
    }

    public function update(TermsAndConditionsRequest $request, Page $page): RedirectResponse
    {
        (new UpdateTermsAndConditionsAction())->handle($request->validated(), $page);

        return back()->with("success", "TERMS_AND_CONDITIONS_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }
}
