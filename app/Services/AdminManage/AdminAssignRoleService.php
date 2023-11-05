<?php

namespace App\Services\AdminManage;

use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminAssignRoleService
{
    public function assign(User $user, int $roleId): void
    {
        $user->assignRole($roleId);

        $role = Role::with('permissions')->where('id', $roleId)->first();

        if ($role) {
            $user->syncPermissions($role->permissions);
        }
    }

    public function updateAssign(User $user, int|null $roleId): void
    {
        if ($roleId) {
            $user->roles()->detach();

            $user->permissions()->detach();

            $user->assignRole($roleId);

            $role = Role::with('permissions')->where('id', $roleId)->first();

            if ($role) {
                $user->syncPermissions($role->permissions);
            }
        }
    }
}
