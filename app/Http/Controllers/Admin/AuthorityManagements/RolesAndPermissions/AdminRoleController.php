<?php

namespace App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions;

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
        Role::create($request->validated());

        return to_route("admin.roles.index", "per_page=$request->per_page")->with("success", "Role has been successfully created.");
    }

    public function edit(Role $role): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Edit", compact("role", "paginate"));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return to_route("admin.roles.index", "page=$request->page&per_page=$request->per_page")->with("success", "Role has been successfully updated.");
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return to_route("admin.roles.index", "page=$request->page&per_page=$request->per_page")->with("success", "Role has been successfully deleted.");
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

    public function restore(Request $request, int $id): RedirectResponse
    {
        $role = Role::onlyTrashed()->findOrFail($id);

        $role->restore();

        return to_route('admin.roles.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Role has been successfully restored.");
    }

    public function forceDelete(Request $request, int $id): RedirectResponse
    {
        $role = Role::onlyTrashed()->findOrFail($id);

        $role->forceDelete();

        return to_route('admin.roles.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The role has been permanently deleted");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $roles = Role::onlyTrashed()->get();

        $roles->each(function ($role) {
            $role->forceDelete();
        });

        return to_route('admin.roles.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Roles have been successfully deleted.");
    }
}
