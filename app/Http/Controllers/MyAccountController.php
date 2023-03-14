<?php

namespace App\Http\Controllers;

use App\Actions\DeleteUserAction;
use Laravolt\Avatar\Avatar;
use App\Http\Requests\MyAccountUpdateRequest;
use App\Services\UserAvatarService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class MyAccountController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('MyAccount/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(MyAccountUpdateRequest $request, UserAvatarService $userAvatarService): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $userAvatarService->regenerateDefaultAvatar($request);

        $userAvatarService->uploadAvatar($request);

        $request->user()->save();

        return Redirect::route('my-account.edit');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        (new DeleteUserAction())->execute($request);

        return Redirect::to('/')->with("success", "Your account is deleted successfully.");
    }
}
