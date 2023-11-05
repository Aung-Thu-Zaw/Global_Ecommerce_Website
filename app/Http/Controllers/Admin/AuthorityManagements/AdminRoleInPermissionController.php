<?php

namespace App\Http\Controllers\Admin\AuthorityManagements;

use App\Actions\Admin\AuthorityManagements\RoleInPermissions\CreateRoleInPermissionsAction;
use App\Actions\Admin\AuthorityManagements\RoleInPermissions\UpdateRoleInPermissionsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleInPermissionRequest;
use App\Http\Traits\HandlesQueryStringParameters;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\ResponseFactory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleInPermissionController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $rolesWithPermissions = Role::with('permissions')
                                    ->filterBy(request(['search', 'created_from', 'created_until']))
                                    ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                    ->paginate(request('per_page', 10))
                                    ->withQueryString();

        return inertia('Admin/AuthorityManagements/RoleInPermissions/Index', compact('rolesWithPermissions'));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request('per_page');

        $roles = Role::with('permissions')->get();

        $permissionGroups = DB::table('permissions')->select('group')->groupBy('group')->get();

        $permissions = Permission::get();

        return inertia('Admin/AuthorityManagements/RoleInPermissions/Create', compact('per_page', 'roles', 'permissions', 'permissionGroups'));
    }

    public function store(RoleInPermissionRequest $request): RedirectResponse
    {
        (new CreateRoleInPermissionsAction())->handle($request->validated());

        return to_route('admin.role-in-permissions.index', $this->getQueryStringParams($request))->with('success', 'ROLE_IN_PERMISSIONS_HAS_BEEN_SUCCESSFULLY_CREATED');
    }

    public function edit(Request $request, Role $role): Response|ResponseFactory
    {
        $permissionGroups = DB::table('permissions')->select('group')->groupBy('group')->get();

        $permissions = Permission::get();

        $role->load('permissions');

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia('Admin/AuthorityManagements/RoleInPermissions/Edit', compact('queryStringParams', 'permissions', 'permissionGroups', 'role'));
    }

    public function update(RoleInPermissionRequest $request, Role $role): RedirectResponse
    {
        (new UpdateRoleInPermissionsAction())->handle($request->validated(), $role);

        return to_route('admin.role-in-permissions.index', $this->getQueryStringParams($request))->with('success', 'ROLE_IN_PERMISSIONS_HAS_BEEN_SUCCESSFULLY_UPDATED');
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->permissions()->detach();

        return to_route('admin.role-in-permissions.index', $this->getQueryStringParams($request))->with('success', 'ROLE_IN_PERMISSIONS_HAS_BEEN_SUCCESSFULLY_DELETED');
    }
}
