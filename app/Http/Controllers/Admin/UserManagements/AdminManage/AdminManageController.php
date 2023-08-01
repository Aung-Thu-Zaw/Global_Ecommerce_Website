<?php

namespace App\Http\Controllers\Admin\UserManagements\AdminManage;

use App\Actions\Admin\UserManagements\AdminManage\CreateAdminAction;
use App\Actions\Admin\UserManagements\AdminManage\UpdateAdminAction;
use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminManageRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AdminManage\AdminAssignRoleService;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class AdminManageController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $admins=User::search(request("search"))
                    ->query(function (Builder $builder) {
                        $builder->with("roles");
                    })
                    ->where("role", "admin")
                    ->where("status", "active")
                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                    ->paginate(request("per_page", 10))
                    ->appends(request()->all());

        return inertia("Admin/UserManagements/AdminManage/Index", compact("admins"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $user->load("roles");

        return inertia("Admin/UserManagements/AdminManage/Details", compact("user", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $roles=Role::all();

        return inertia("Admin/UserManagements/AdminManage/Create", compact("per_page", "roles"));
    }

    public function store(AdminManageRequest $request, AdminAssignRoleService $adminAssignRoleService): RedirectResponse
    {
        $admin=(new CreateAdminAction())->handle($request->validated());

        $adminAssignRoleService->assign($admin, $request->assign_role);

        $queryStringParams=["page"=>"1","per_page"=>$request->per_page,"sort"=>"id","direction"=>"desc"];

        return to_route("admin.admin-manage.index", $queryStringParams)->with("success", "Admin has been successfully created.");
    }

    public function edit(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        $roles=Role::all();

        $user->load("roles");

        return inertia("Admin/UserManagements/AdminManage/Edit", compact("user", "roles", "queryStringParams"));
    }

    public function update(AdminManageRequest $request, User $user, AdminAssignRoleService $adminAssignRoleService): RedirectResponse
    {
        $admin=(new UpdateAdminAction())->handle($request->validated(), $user);

        $adminAssignRoleService->updateAssign($admin, $request->assign_role);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.admin-manage.index", $queryStringParams)->with("success", "Admin has been successfully updated.");
    }


    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route("admin.admin-manage.index", $queryStringParams)->with("success", "Admin has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashAdmins=User::search(request("search"))
                         ->query(function (Builder $builder) {
                             $builder->with("roles");
                         })
                         ->onlyTrashed()
                         ->orderBy(request("sort", "id"), request("direction", "desc"))
                         ->paginate(request("per_page", 10))
                         ->appends(request()->all());

        return inertia("Admin/UserManagements/AdminManage/Trash", compact("trashAdmins"));
    }

    public function restore(Request $request, int $trashAdminId): RedirectResponse
    {
        $admin = User::onlyTrashed()->findOrFail($trashAdminId);

        $admin->restore();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.admin-manage.trash', $queryStringParams)->with("success", "Admin has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashAdminId): RedirectResponse
    {
        $admin = User::onlyTrashed()->findOrFail($trashAdminId);

        User::deleteUserAvatar($admin->avatar);

        $admin->forceDelete();

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.admin-manage.trash', $queryStringParams)->with("success", "The admin has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $admins = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($admins);

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return to_route('admin.admin-manage.trash', $queryStringParams)->with("success", "Admins have been successfully deleted.");
    }
}
