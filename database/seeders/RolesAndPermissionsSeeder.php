<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view products',
            'create products',
            'edit products',
           'statistic products',
            'view users',
            'edit users',
            'cart',
            'view notifications' 
            
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
 
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $modRole = Role::firstOrCreate(['name' => 'mod']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
 
        $adminRole->givePermissionTo(Permission::all());

        $modRole->givePermissionTo([
            'view products',
            'create products',
            'edit products',
           'statistic products',
            'cart'
        ]);
        $customerRole->givePermissionTo([
            'cart'
        ]);
    }
}

