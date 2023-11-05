<?php

namespace App\Http\Controllers\User;

use App\Actions\DeleteUserAction;
use App\Events\AccountDeleted;
use App\Http\Controllers\Controller;
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
        $user = $request->user();

        if ($user) {
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $userAvatarService->regenerateDefaultAvatar($request);
            $userAvatarService->uploadAvatar($request);

            $user->save();
        }

        return to_route('my-account.edit', 'tab=edit-profile')->with('success', 'PROFILE_UPDATED_SUCCESSFULLY');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user) {
            (new DeleteUserAction())->execute($request);

            event(new AccountDeleted($user));
        }

        return Redirect::to('/')->with('success', 'YOUR_ACCOUNT_IS_DELETED_SUCCESSFULLY');
    }
}
