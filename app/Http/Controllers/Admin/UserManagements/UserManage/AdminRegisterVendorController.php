<?php

namespace App\Http\Controllers\Admin\UserManagements\UserManage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;

class AdminRegisterVendorController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $vendors=User::search(request("search"))
                    ->where("role", "vendor")
                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                    ->paginate(request("per_page", 10))
                    ->appends(request()->all());

        return inertia("Admin/UserManagements/UserManage/RegisterVendors/Index", compact("vendors"));
    }

    public function show(User $user): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        if(request()->noti_id) {
            $notification=auth()->user()->notifications()->where("id", request()->noti_id)->first();

            $notification->update(['read_at' => now()]);
        }

        return inertia("Admin/UserManagements/UserManage/RegisterVendors/Details", compact("user", "paginate"));
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return to_route("admin.vendors.register.index", "page=$request->page&per_page=$request->per_page")->with("success", "Vendor has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashVendors=User::search(request("search"))
                         ->onlyTrashed()
                         ->where("role", "vendor")
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(request("per_page", 10))
                         ->appends(request()->all());

        return inertia("Admin/UserManagements/UserManage/RegisterVendors/Trash", compact("trashVendors"));
    }

    public function restore(Request $request, int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->restore();

        return to_route('admin.vendors.register.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Vendor has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->forceDelete();

        return to_route('admin.vendors.register.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The vendor has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $users = User::onlyTrashed()->get();

        $users->each(function ($user) {

            User::deleteUserAvatar($user);

            $user->forceDelete();
        });

        return to_route('admin.vendors.register.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Vendors have been successfully deleted.");
    }
}
