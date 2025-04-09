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
        ]);
    }
}
