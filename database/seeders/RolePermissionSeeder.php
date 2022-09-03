<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        $roleAdmin= Role::create(['name' => 'admin']);
        $roleUser= Role::create(['name' => 'user']);

        // Permission List as array
        $permissions = [
            
            // user permission
            'user.create',
            'user.view',
            'user.edit',
            'user.delete',
            'user.approve',

            // profile permission
            'profile.create',
            'profile.view',
        ];

        // Create and Assign Permission
        for ($i=0; $i < count($permissions) ; $i++) { 
            // create permission
            $permission = Permission::create(['name' => $permissions[$i]]);
            $roleAdmin->givePermissionTo($permission);
            $permission->assignRole($roleAdmin);
        }

        $roleUser->givePermissionTo($permissions[5]);
        $permission->assignRole($roleUser);

        $roleUser->givePermissionTo($permissions[6]);
        $permission->assignRole($roleUser);
    }
}
