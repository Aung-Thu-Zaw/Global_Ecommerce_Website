<?php

namespace App\Http\Controllers\Admin\AuthorityManagements;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleInPermissionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $rolesWithPermissions=Role::search(request("search"))
                                  ->query(function (Builder $builder) {
                                      $builder->with("permissions");
                                  })
                                  ->orderBy(request("sort", "id"), request("direction", "desc"))
                                  ->paginate(request("per_page", 10))
                                  ->appends(request()->all());

        return inertia("Admin/AuthorityManagements/RoleInPermissions/Index", compact("rolesWithPermissions"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page=request("per_page");

        $roles=Role::all();

        $permissions=Permission::all();

        return inertia("Admin/AuthorityManagements/RoleInPermissions/Create", compact("per_page", "roles", "permissions"));
    }

    // public function store(PermissionRequest $request): RedirectResponse
    // {
    //     Permission::create($request->validated());

    //     return to_route("admin.permissions.index", "per_page=$request->per_page")->with("success", "Permission has been successfully created.");
    // }

    // public function edit(Permission $permission): Response|ResponseFactory
    // {
    //     $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

    //     return inertia("Admin/AuthorityManagements/RoleInPermissions/Edit", compact("permission", "paginate"));
    // }

    // public function update(PermissionRequest $request, Permission $permission): RedirectResponse
    // {
    //     $permission->update($request->validated());

    //     return to_route("admin.permissions.index", "page=$request->page&per_page=$request->per_page")->with("success", "Permission has been successfully updated.");
    // }

    // public function destroy(Request $request, Permission $permission): RedirectResponse
    // {
    //     $permission->delete();

    //     return to_route("admin.permissions.index", "page=$request->page&per_page=$request->per_page")->with("success", "Permission has been successfully deleted.");
    // }

    // public function trash(): Response|ResponseFactory
    // {
    //     $trashPermissions=Permission::search(request("search"))
    //                       ->onlyTrashed()
    //                       ->orderBy(request("sort", "id"), request("direction", "desc"))
    //                       ->paginate(request("per_page", 10))
    //                       ->appends(request()->all());

    //     return inertia("Admin/AuthorityManagements/RoleInPermissions/Trash", compact("trashPermissions"));
    // }

    // public function restore(Request $request, int $id): RedirectResponse
    // {
    //     $permission = Permission::onlyTrashed()->findOrFail($id);

    //     $permission->restore();

    //     return to_route('admin.permissions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Permission has been successfully restored.");
    // }

    // public function forceDelete(Request $request, int $id): RedirectResponse
    // {
    //     $permission = Permission::onlyTrashed()->findOrFail($id);

    //     $permission->forceDelete();

    //     return to_route('admin.permissions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "The permission has been permanently deleted");
    // }

    // public function permanentlyDelete(Request $request): RedirectResponse
    // {
    //     $permissions = Permission::onlyTrashed()->get();

    //     $permissions->each(function ($permission) {
    //         $permission->forceDelete();
    //     });

    //     return to_route('admin.permissions.trash', "page=$request->page&per_page=$request->per_page")->with("success", "Permissions have been successfully deleted.");
    // }
}
