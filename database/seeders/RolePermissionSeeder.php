<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('nama', 'superadmin')->first();
        $permissions = Permission::get();
        foreach ($permissions as $item) {
            RolePermission::create([
                'id_role_permission' => Uuid::uuid4(),
               'id_role' => $role->id_role,
               'id_permission' => $item->id_permission 
            ]);
        }
    }
}
