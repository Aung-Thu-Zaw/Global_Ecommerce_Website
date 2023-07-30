<?php

namespace App\Http\Controllers\Admin\AdminWebControlArea\SiteSettings;

use App\Actions\Admin\AdminWebControlArea\Settings\SeoSetting\UpdateSeoSettingAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeoSettingRequest;
use App\Models\SeoSetting;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminSeoSettingController extends Controller
{
    public function edit(): Response|ResponseFactory
    {
        $seoSetting=SeoSetting::find(1);

        return inertia("Admin/AdminWebControlArea/Settings/SeoSettings/Edit", compact("seoSetting"));
    }

    public function update(SeoSettingRequest $request, SeoSetting $seoSetting): RedirectResponse
    {
        (new UpdateSeoSettingAction())->handle($request->validated(), $seoSetting);

        return back()->with("success", "SEO Setting has been successfully updated.");
    }
}
