<?php

namespace App\Http\Controllers\Admin\AuthorityManagements\RolesAndPermissions;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;
use Spatie\Permission\Models\Permission;

class AdminPermissionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $permissions = Permission::filterBy(request(['search', 'created_from', 'created_until']))
                                 ->orderBy(request('sort', 'id'), request('direction', 'desc'))
                                 ->paginate(request('per_page', 10))
                                 ->withQueryString();

        return inertia('Admin/AuthorityManagements/RolesAndPermissions/Permissions/Index', compact('permissions'));
    }
}
