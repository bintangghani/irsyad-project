<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis')->insert([
            [
                'id_jenis' => Str::uuid(),
                'nama' => 'Buku Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jenis' => Str::uuid(),
                'nama' => 'Buku Cetak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
