<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'id_role' => Uuid::uuid4(),
                'nama' => 'superadmin',
            ],
            [
                'id_role' => Uuid::uuid4(),
                'nama' => 'client'
            ]
        ]);
    }
}
