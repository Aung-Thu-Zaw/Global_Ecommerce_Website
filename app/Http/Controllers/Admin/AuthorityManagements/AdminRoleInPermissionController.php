<?php

namespace App\Http\Controllers\Admin\AuthorityManagements;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleInPermissionRequest;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $roles=Role::with("permissions")->get();

        $permissionGroups = DB::table('permissions')->select('group')->groupBy('group')->get();

        $permissions=Permission::get();

        return inertia("Admin/AuthorityManagements/RoleInPermissions/Create", compact("per_page", "roles", "permissions", "permissionGroups"));
    }

    public function store(RoleInPermissionRequest $request): RedirectResponse
    {
        foreach($request->permission_id as $key => $value) {

            DB::table('role_has_permissions')->insert([

                "role_id"=>$request->role_id,
                "permission_id"=>$value

            ]);

        }

        return to_route("admin.role-in-permissions.index", "per_page=$request->per_page")->with("success", "Role in permissions has been successfully created.");
    }

    public function edit(Role $role): Response|ResponseFactory
    {
        $paginate=[ "page"=>request("page"),"per_page"=>request("per_page")];

        $permissionGroups = DB::table('permissions')->select('group')->groupBy('group')->get();

        $permissions=Permission::get();

        $role->load("permissions");

        return inertia("Admin/AuthorityManagements/RoleInPermissions/Edit", compact("paginate", "permissions", "permissionGroups", "role"));
    }

    public function update(RoleInPermissionRequest $request, Role $role): RedirectResponse
    {

        $role->permissions()->detach();

        foreach($request->permission_id as $key => $value) {
            $role->permissions()->attach(["permission_id"=>$value]);
        }

        $role->users->each(function ($user) use ($role) {
            $user->syncPermissions($role->permissions);
        });


        return to_route("admin.role-in-permissions.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Role in permissions has been successfully updated.");
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->permissions()->detach();

        return to_route("admin.role-in-permissions.index", "page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction")->with("success", "Role in permissions has been successfully deleted.");
    }
}
