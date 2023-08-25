<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PrivacyPolicyRequest;
use App\Models\Page;
use App\Actions\Admin\AdminWebControlArea\WebsitePages\PrivacyPolicy\UpdatePrivacyPolicyAction;

class AdminPrivacyPolicyController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $privacyPolicy = Page::findOrFail(1);

        return inertia("Admin/AdminWebControlArea/WebsitePages/PrivacyPolicy/Edit", compact("privacyPolicy"));
    }

    public function update(PrivacyPolicyRequest $request, Page $page): RedirectResponse
    {
        (new UpdatePrivacyPolicyAction())->handle($request->validated(), $page);

        return back()->with("success", "PRIVACY_POLICY_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }
}
