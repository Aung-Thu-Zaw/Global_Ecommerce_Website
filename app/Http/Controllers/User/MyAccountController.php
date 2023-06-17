<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Actions\DeleteUserAction;
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
        return Inertia::render('User/MyAccount/Edit', [
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

        return to_route('my-account.edit', 'tab=edit-profile')->with("success", "Profile updated successfully");
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
