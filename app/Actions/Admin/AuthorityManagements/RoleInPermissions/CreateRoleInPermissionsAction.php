<?php

namespace App\Actions\Admin\AuthorityManagements\RoleInPermissions;

use Illuminate\Support\Facades\DB;

class CreateRoleInPermissionsAction
{
    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): void
    {
        foreach ($data['permission_id'] as $key => $value) {
            DB::table('role_has_permissions')->insert([

                'role_id' => $data['role_id'],
                'permission_id' => $value,

            ]);
        }
    }
}
