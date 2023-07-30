<?php

namespace App\Actions\Admin\AuthorityManagements\RolesAndPermissions\Roles;

use Spatie\Permission\Models\Role;

class UpdateRoleAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data, Role $role): void
    {
        $role->update([
            "name"=>$data["name"],
        ]);
    }
}
