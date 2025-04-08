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
                'nama' => 'view_dashboard'
            ],
            [
                'nama' => 'view_user'
            ],
            [
                'nama' => 'create_user'
            ],
            [
                'nama' => 'update_user'
            ],
            [
                'nama' => 'update_profile'
            ],
            [
                'nama' => 'verified_user'
            ],
            [
                'nama' => 'delete_user'
            ],
            [
                'nama' => 'view_role'
            ],
            [
                'nama' => 'create_role'
            ],
            [
                'nama' => 'update_role'
            ],
            [
                'nama' => 'delete_role'
            ],
        ]);
    }
}
