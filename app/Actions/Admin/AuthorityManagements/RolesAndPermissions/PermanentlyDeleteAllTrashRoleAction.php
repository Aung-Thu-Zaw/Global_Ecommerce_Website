<?php

namespace App\Actions\Admin\AuthorityManagements\RolesAndPermissions;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class PermanentlyDeleteAllTrashRoleAction
{
    /**
     * @param  Collection<int,Role>  $roles
     */
    public function handle(Collection $roles): void
    {
        $roles->each(function ($role) {
            $role->forceDelete();
        });
    }
}
