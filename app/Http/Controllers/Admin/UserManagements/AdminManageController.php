<?php

namespace App\Http\Controllers\Admin\UserManagements;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\AdminManageRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Actions\Admin\UserManagements\AdminManage\CreateAdminAction;
use App\Actions\Admin\UserManagements\AdminManage\UpdateAdminAction;
use App\Actions\Admin\UserManagements\PermanentlyDeleteAllTrashUserAction;
use App\Services\AdminManage\AdminAssignRoleService;
use App\Http\Traits\HandlesQueryStringParameters;

class AdminManageController extends Controller
{
    use HandlesQueryStringParameters;

    public function index(): Response|ResponseFactory
    {
        $admins = User::with("roles")
                      ->filterBy(request(["search","created_from","created_until"]))
                      ->where("role", "admin")
                      ->where("status", "active")
                      ->orderBy(request("sort", "id"), request("direction", "desc"))
                      ->paginate(request("per_page", 10))
                      ->appends(request()->all());

        return inertia("Admin/UserManagements/AdminManage/Index", compact("admins"));
    }

    public function show(Request $request, User $user): Response|ResponseFactory
    {
        $queryStringParams = $this->getQueryStringParams($request);

        $user->load("roles");

        return inertia("Admin/UserManagements/AdminManage/Detail", compact("user", "queryStringParams"));
    }

    public function create(): Response|ResponseFactory
    {
        $per_page = request("per_page");

        $roles = Role::all();

        return inertia("Admin/UserManagements/AdminManage/Create", compact("per_page", "roles"));
    }

    public function store(AdminManageRequest $request, AdminAssignRoleService $adminAssignRoleService): RedirectResponse
    {
        $admin = (new CreateAdminAction())->handle($request->validated());

        $adminAssignRoleService->assign($admin, $request->assign_role);

        return to_route("admin.admin-manage.index", $this->getQueryStringParams($request))->with("success", "ADMIN_HAS_BEEN_SUCCESSFULLY_CREATED");
    }

    public function edit(Request $request, User $user): Response|ResponseFactory
    {
        $roles = Role::all();

        $user->load("roles");

        $queryStringParams = $this->getQueryStringParams($request);

        return inertia("Admin/UserManagements/AdminManage/Edit", compact("user", "roles", "queryStringParams"));
    }

    public function update(AdminManageRequest $request, User $user, AdminAssignRoleService $adminAssignRoleService): RedirectResponse
    {
        $admin = (new UpdateAdminAction())->handle($request->validated(), $user);

        $adminAssignRoleService->updateAssign($admin, $request->assign_role);

        return to_route("admin.admin-manage.index", $this->getQueryStringParams($request))->with("success", "ADMIN_HAS_BEEN_SUCCESSFULLY_UPDATED");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return to_route("admin.admin-manage.index", $this->getQueryStringParams($request))->with("success", "ADMIN_HAS_BEEN_SUCCESSFULLY_DELETED");
    }

    public function trash(): Response|ResponseFactory
    {
        $trashAdmins = User::with("roles")
                           ->filterBy(request(["search","deleted_from","deleted_until"]))
                           ->onlyTrashed()
                           ->orderBy(request("sort", "id"), request("direction", "desc"))
                           ->paginate(request("per_page", 10))
                           ->appends(request()->all());

        return inertia("Admin/UserManagements/AdminManage/Trash", compact("trashAdmins"));
    }

    public function restore(Request $request, int $trashAdminId): RedirectResponse
    {
        $trashAdmin = User::onlyTrashed()->findOrFail($trashAdminId);

        $trashAdmin->restore();

        return to_route('admin.admin-manage.trash', $this->getQueryStringParams($request))->with("success", "ADMIN_HAS_BEEN_SUCCESSFULLY_RESTORED");
    }

    public function forceDelete(Request $request, int $trashAdminId): RedirectResponse
    {
        $trashAdmin = User::onlyTrashed()->findOrFail($trashAdminId);

        User::deleteUserAvatar($trashAdmin->avatar);

        $trashAdmin->forceDelete();

        return to_route('admin.admin-manage.trash', $this->getQueryStringParams($request))->with("success", "THE_ADMIN_HAS_BEEN_PERMANENTLY_DELETED");
    }

    public function permanentlyDelete(Request $request): RedirectResponse
    {
        $trashAdmins = User::onlyTrashed()->get();

        (new PermanentlyDeleteAllTrashUserAction())->handle($trashAdmins);

        return to_route('admin.admin-manage.trash', $this->getQueryStringParams($request))->with("success", "ADMINS_HAVE_BEEN_PERMANENTLY_DELETED");
    }
}
