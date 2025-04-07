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
        $kelompokData = [
            ['nama' => 'Fiksi'],
            ['nama' => 'Non-Fiksi'],
            ['nama' => 'Referensi'],
            ['nama' => 'Anak-Anak'],
            ['nama' => 'Buku Pelajaran Sekolah'],
        ];

        $kelompokIDs = [];

        foreach ($kelompokData as $data) {
            $uuid = Str::uuid();
            DB::table('kelompok')->insert([
                'id_kelompok' => $uuid,
                'nama' => $data['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $kelompokIDs[$data['nama']] = $uuid;
        }

        cache()->put('kelompok_ids', $kelompokIDs, now()->addMinutes(10));
    }
}
