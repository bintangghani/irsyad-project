<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_dashboard'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_user'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_user'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_user'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_profile'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'verified_user'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_user'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_role'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_role'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_role'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_role'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_permission'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_permission'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_permission'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_permission'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'import_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_jenis'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_jenis'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_jenis'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_jenis'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_kelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_kelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_kelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_kelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_subkelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_subkelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_subkelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_subkelompok'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'create_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'delete_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'import_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_profile_instansi'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'read_buku'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'show_buku_client'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'show_category_client'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'show_instansi_client'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_user_client'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_site_settings'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'update_site_settings'
            ],
            [
                'id_permission' => Uuid::uuid4(),
                'nama' => 'view_laporan'
            ],
        ]);
    }
}
