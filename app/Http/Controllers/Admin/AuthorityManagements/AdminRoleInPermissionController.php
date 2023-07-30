<?php

namespace App\Http\Controllers\Admin\AuthorityManagements;

use App\Actions\Admin\AuthorityManagements\RoleInPermissions\CreateRoleInPermissionsAction;
use App\Actions\Admin\AuthorityManagements\RoleInPermissions\UpdateRoleInPermissionsAction;
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
        (new CreateRoleInPermissionsAction())->handle($request->validated());

        $urlStringQuery="page=1&per_page=$request->per_page&sort=id&direction=desc";

        return to_route("admin.role-in-permissions.index", $urlStringQuery)->with("success", "Role in permissions has been successfully created.");
    }

    public function edit(Request $request, Role $role): Response|ResponseFactory
    {
        $permissionGroups = DB::table('permissions')->select('group')->groupBy('group')->get();

        $permissions=Permission::get();

        $role->load("permissions");

        $queryStringParams=["page"=>$request->page,"per_page"=>$request->per_page,"sort"=>$request->sort,"direction"=>$request->direction];

        return inertia("Admin/AuthorityManagements/RoleInPermissions/Edit", compact("queryStringParams", "permissions", "permissionGroups", "role"));
    }

    public function update(RoleInPermissionRequest $request, Role $role): RedirectResponse
    {
        (new UpdateRoleInPermissionsAction())->handle($request->validated(), $role);

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.role-in-permissions.index", $urlStringQuery)->with("success", "Role in permissions has been successfully updated.");
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->permissions()->detach();

        $urlStringQuery="page=$request->page&per_page=$request->per_page&sort=$request->sort&direction=$request->direction";

        return to_route("admin.role-in-permissions.index", $urlStringQuery)->with("success", "Role in permissions has been successfully deleted.");
    }
}
