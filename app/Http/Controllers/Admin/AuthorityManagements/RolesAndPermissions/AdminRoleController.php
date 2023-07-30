<?php

namespace App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions;

use App\Actions\Admin\AuthorityManagements\RolesAndPermissions\Roles\CreateRoleAction;
use App\Actions\Admin\AuthorityManagements\RolesAndPermissions\Roles\UpdateRoleAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $roles=Role::search(request("search"))
                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                   ->paginate(request("per_page", 10))
                   ->appends(request()->all());

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Index", compact("roles"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Create", compact("per_page"));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        (new CreateRoleAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.roles.index", $urlStringQuery)->with("success", "Role has been successfully created.");
    }

    public function edit(Request $request, Role $role): Response|ResponseFactory
    {
        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Edit", compact("role", "queryStringParams"));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        (new UpdateRoleAction())->handle($request->validated(), $role);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.roles.index", $urlStringQuery)->with("success", "Role has been successfully updated.");
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.roles.index", $urlStringQuery)->with("success", "Role has been successfully deleted.");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashRoles=Role::search(request("search"))
                        ->onlyTrashed()
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(request("per_page", 10))
                        ->appends(request()->all());

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Trash", compact("trashRoles"));
    }

    public function restore(Request $request, int $trashRoleId): RedirectResponse
    {
        $role = Role::onlyTrashed()->findOrFail($trashRoleId);

        $role->restore();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.roles.trash', $urlStringQuery)->with("success", "Role has been successfully restored.");
    }

    public function forceDelete(Request $request, int $trashRoleId): RedirectResponse
    {
        $role = Role::onlyTrashed()->findOrFail($trashRoleId);

        $role->forceDelete();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.roles.trash', $urlStringQuery)->with("success", "The role has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $roles = Role::onlyTrashed()->get();

        $roles->each(function ($role) {

            $role->forceDelete();

        });

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route('admin.roles.trash', $urlStringQuery)->with("success", "Roles have been successfully deleted.");
    }
}
