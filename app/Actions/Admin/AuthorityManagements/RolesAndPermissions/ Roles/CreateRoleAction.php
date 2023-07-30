<?php

namespace App\Actions\Admin\AuthorityManagements\RolesAndPermissions\Roles;

use Spatie\Permission\Models\Role;

class CreateRoleAction
{
    /**
     * @param array<mixed> $data
     */
    public function handle(array $data): void
    {
        Role::create([
            "name"=>$data["name"],
        ]);
    }
}
