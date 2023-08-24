<?php

namespace App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions;

use App\Actions\Admin\AuthorityManagements\RolesAndPermissions\PermanentlyDeleteAllTrashRoleAction;
use App\Http\Traits\HandlesQueryStringParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $roles = Role::filterBy(request(["search","created_from","created_until","deleted_from","deleted_until"]))
                   ->orderBy(request("sort", "id"), request("direction", "desc"))
                   ->paginate(request("per_page", 10))
                   ->appends(request()->all());

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Index", compact("roles"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Create", compact("per_page"));
    }

    public function store(RoleRequest $request): RedirectResponse
    {
        Role::create(["name" => $request->name]);

        return to_route("admin.roles.index", $this->getQueryStringParams($request))->with("success", "ROLE_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, Role $role): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Edit", compact("role", "queryStringParams"));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update(["name" => $request->name]);

        return to_route("admin.roles.index", $this->getQueryStringParams($request))->with("success", "ROLE_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return to_route("admin.roles.index", $this->getQueryStringParams($request))->with("success", "ROLE_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashRoles = Role::filterBy(request(["search","created_from","created_until","deleted_from","deleted_until"]))
                        ->onlyTrashed()
                        ->orderBy(request("sort", "id"), request("direction", "desc"))
                        ->paginate(request("per_page", 10))
                        ->appends(request()->all());

        return inertia("Admin/AuthorityManagements/RolesAndPermissions/Roles/Trash", compact("trashRoles"));
    }

    public function restore(Request $request, int $trashRoleId): RedirectResponse
    {
        $trashRole = Role::onlyTrashed()->findOrFail($trashRoleId);

        $trashRole->restore();

        return to_route('admin.roles.trash', $this->getQueryStringParams($request))->with("success", "ROLE_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashRoleId): RedirectResponse
    {
        $trashRole = Role::onlyTrashed()->findOrFail($trashRoleId);

        $trashRole->forceDelete();

        return to_route('admin.roles.trash', $this->getQueryStringParams($request))->with("success", "THE_ROLE_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashRoles = Role::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashRoleAction())->handle($trashRoles);

        return to_route('admin.roles.trash', $this->getQueryStringParams($request))->with("success", "ROLES_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
