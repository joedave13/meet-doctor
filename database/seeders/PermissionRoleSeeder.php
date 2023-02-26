<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin_role = Role::query()->findOrFail(1);
        $superadmin_permissions = Permission::all();
        $superadmin_role->permissions()->sync($superadmin_permissions->pluck('id'));

        $admin_role = Role::query()->findOrFail(2);
        $admin_permissions = $superadmin_permissions->filter(function ($permission) {
            return substr($permission->name, 0, 5) != 'user_' && substr($permission->name, 0, 5) != 'role_' && substr($permission->name, 0, 11) != 'permission_';
        });
        $admin_role->permissions()->sync($admin_permissions);
    }
}
