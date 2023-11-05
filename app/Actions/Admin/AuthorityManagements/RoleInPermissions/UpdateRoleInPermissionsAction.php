<?php

namespace App\Actions\Admin\AuthorityManagements\RoleInPermissions;

use Spatie\Permission\Models\Role;

class UpdateRoleInPermissionsAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, Role $role): void
    {
        $role->permissions()->detach();

        foreach ($data['permission_id'] as $key => $value) {
            $role->permissions()->attach(['permission_id' => $value]);
        }

        $role->users->each(function ($user) use ($role) {
            $user->syncPermissions($role->permissions);
        });
    }
}
