<?php

namespace App\Http\Controllers\Admin\UserManagements\RegisteredAccounts;

use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminRegisteredVendorController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $vendors=User::search(request("search"))
                     ->where("role", "vendor")
                     ->orderBy(request("sort", "id"), request("direction", "desc"))
                     ->paginate(request("per_page", 10))
                     ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredVendors/Index", compact("vendors"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredVendors/Details", compact("user", "queryStringParams"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.vendors.registered.index", $queryStringParams)->with("success", "Vendor has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashVendors=User::search(request("search"))
                          ->onlyTrashed()
                          ->where("role", "vendor")
                          ->orderBy(request("sort", "id"), request("direction", "desc"))
                          ->paginate(request("per_page", 10))
                          ->appends(request()->all());

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredVendors/Trash", compact("trashVendors"));
    }

    public function restore(Request $request, int $trashRegisteredVendorId): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($trashRegisteredVendorId);

        $user->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.registered.trash', $queryStringParams)->with("success", "Vendor has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashRegisteredVendorId): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($trashRegisteredVendorId);

        User::deleteUserAvatar($user->avatar);

        $user->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.registered.trash', $queryStringParams)->with("success", "The vendor has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $users = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($users);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.vendors.registered.trash', $queryStringParams)->with("success", "Vendors have been successfully deleted.");
    }
}
