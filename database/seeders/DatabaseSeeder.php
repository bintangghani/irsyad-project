<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            // Jenis Buku //
            JenisSeeder::class,
            KelompokSeeder::class,
            SubKelompokSeeder::class
        ]);
    }
}
