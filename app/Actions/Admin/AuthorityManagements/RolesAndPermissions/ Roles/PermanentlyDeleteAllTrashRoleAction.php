<?php

namespace App\Actions\Admin\AuthorityManagements\RolesAndPermissions\Roles;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

class PermanentlyDeleteAllTrashRoleAction
{
    /**
    * @param Collection<int,Role> $roles
    */

    public function handle(Collection $roles): void
    {
        $roles->each(function ($role) {

            $role->forceDelete();

        });
    }
}
