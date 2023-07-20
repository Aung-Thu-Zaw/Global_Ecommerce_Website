<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\WebsitePages;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrivacyPolicyRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminPrivacyPolicyController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $privacyPolicy=Page::findOrFail(1);

        return inertia("Admin/AdminWebControlArea/WebsitePages/PrivacyPolicy/Edit", compact("privacyPolicy"));
    }

    public function update(PrivacyPolicyRequest $request, Page $page): RedirectResponse
    {
        $page->update($request->validated());

        return back()->with("success", "Privacy policy has been successfully updated.");
    }
}
