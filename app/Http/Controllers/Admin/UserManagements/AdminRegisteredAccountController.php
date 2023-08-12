<?php

namespace App\Http\Controllers\Admin\UserManagements;

use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegisteredAccountController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $users=User::search(request("search"))
                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                   ->paginate(request("per_page", 10))
                   ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/Index", compact("users"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=$this->getQueryStringParams($request);

        return inertia("Admin/UserManagements/RegisteredAccounts/Details", compact("user", "queryStringParams"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return to_route("admin.registered-accounts.index", $this->getQueryStringParams($request))->with("success", "USER_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashUsers=User::search(request("search"))
                        ->onlyTrashed()
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(request("per_page", 10))
                        ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/Trash", compact("trashUsers"));
    }

    public function restore(Request $request, int $trashRegisteredAccountId): RedirectResponse
    {
        $trashRegisteredAccount = User::onlyTrashed()->findOrFail($trashRegisteredAccountId);

        $trashRegisteredAccount->restore();

        return to_route('admin.registered-accounts.trash', $this->getQueryStringParams($request))->with("success", "USER_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashRegisteredAccountId): RedirectResponse
    {
        $trashRegisteredAccount = User::onlyTrashed()->findOrFail($trashRegisteredAccountId);

        User::deleteUserAvatar($trashRegisteredAccount->avatar);

        $trashRegisteredAccount->forceDelete();

        return to_route('admin.registered-accounts.trash', $this->getQueryStringParams($request))->with("success", "THE_USER_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashRegisteredAccounts = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($trashRegisteredAccounts);

        return to_route('admin.registered-accounts.trash', $this->getQueryStringParams($request))->with("success", "USERS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
