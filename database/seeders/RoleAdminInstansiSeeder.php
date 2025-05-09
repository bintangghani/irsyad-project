<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RoleAdminInstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('nama', 'admin instansi')->first();
        $permissions = Permission::whereIn('nama', [
            'view_dashboard',
            'view_buku',
            'create_buku',
            'update_buku',
            'delete_buku',
            'read_buku',
            'show_buku_client',
            'show_category_client',
            'show_instansi_client',
            'update_user_client',
            'view_pprofile_instansi'
        ])->get();
        foreach ($permissions as $item) {
            RolePermission::create([
                'id_role_permission' => Uuid::uuid4(),
                'id_role' => $role->id_role,
                'id_permission' => $item->id_permission
            ]);
        }
    }
}
