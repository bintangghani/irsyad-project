<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kelompok')->insert([
            [
                'id_kelompok' => Str::uuid(),
                'nama' => 'Fiksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kelompok' => Str::uuid(),
                'nama' => 'Non-Fiksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kelompok' => Str::uuid(),
                'nama' => 'Referensi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kelompok' => Str::uuid(),
                'nama' => 'Anak-Anak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_kelompok' => Str::uuid(),
                'nama' => 'Buku Pelajaran Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
