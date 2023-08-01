<?php

namespace App\Http\Controllers\Admin\UserManagements\RegisteredAccounts;

use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegisteredUserController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $users=User::search(request("search"))
                   ->where("role", "user")
                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                   ->paginate(request("per_page", 10))
                   ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredUsers/Index", compact("users"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredUsers/Details", compact("user", "queryStringParams"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.users.registered.index", $queryStringParams)->with("success", "User has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashUsers=User::search(request("search"))
                        ->onlyTrashed()
                        ->where("role", "user")
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(request("per_page", 10))
                        ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredUsers/Trash", compact("trashUsers"));
    }

    public function restore(Request $request, int $trashRegisteredUserId): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($trashRegisteredUserId);

        $user->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.users.registered.trash', $queryStringParams)->with("success", "User has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashRegisteredUserId): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($trashRegisteredUserId);

        User::deleteUserAvatar($user->avatar);

        $user->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.users.registered.trash', $queryStringParams)->with("success", "The user has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $users = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($users);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.users.registered.trash', $queryStringParams)->with("success", "Users have been successfully deleted.");
    }
}
