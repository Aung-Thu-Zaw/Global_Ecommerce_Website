<?php

namespace App\Http\Controllers\Admin\UserManagements\UserManage;

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

    public function show(User $user): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/UserManagements/RegisteredAccounts/RegisteredVendors/Details", compact("user", "paginate"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return to_route("admin.vendors.registered.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Vendor has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return to_route('admin.vendors.registered.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Vendor has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->forceDelete();

        return to_route('admin.vendors.registered.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "The vendor has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $users = User::onlyTrashed()->get();

        $users->each(function ($user) {

            User::deleteUserAvatar($user);

            $user->forceDelete();
        });

        return to_route('admin.vendors.registered.trash', "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Vendors have been successfully deleted.");
    }
}