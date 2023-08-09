<?php

namespace App\Http\Controllers\Admin\UserManagements;

use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegisteredAccountController extends Controller
{
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
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/RegisteredAccounts/Details", compact("user", "queryStringParams"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.registered-accounts.index", $queryStringParams)->with("success", "User has been successfully deleted.");
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

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.registered-accounts.trash', $queryStringParams)->with("success", "User has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashRegisteredAccountId): RedirectResponse
    {
        $trashRegisteredAccount = User::onlyTrashed()->findOrFail($trashRegisteredAccountId);

        User::deleteUserAvatar($trashRegisteredAccount->avatar);

        $trashRegisteredAccount->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.registered-accounts.trash', $queryStringParams)->with("success", "The user has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashRegisteredAccounts = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($trashRegisteredAccounts);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.registered-accounts.trash', $queryStringParams)->with("success", "Users have been successfully deleted.");
    }
}
