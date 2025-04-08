<?php

namespace Database\Seeders;

use App\Models\Jenis;
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
        Jenis::insert([
            [
                'nama' => 'Buku Elektronik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Buku Cetak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
