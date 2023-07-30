<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages;

use App\Actions\Admin\AdminWebControlArea\WebsitePages\TermsAndConditions\UpdateTermsAndConditionsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\TermsAndConditionsRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminTermsAndConditionsController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $termsAndConditions=Page::findOrFail(2);

        return inertia("Admin/AdminWebControlArea/WebsitePages/TermsAndConditions/Edit", compact("termsAndConditions"));
    }

    public function update(TermsAndConditionsRequest $request, Page $page): RedirectResponse
    {
        (new UpdateTermsAndConditionsAction())->handle($request->validated(), $page);

        return back()->with("success", "Terms and conditions has been successfully updated.");
    }
}
