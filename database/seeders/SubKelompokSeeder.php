<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubKelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kelompok dari cache
        $kelompokIDs = cache()->get('kelompok_ids');

        // Pastikan ID ada sebelum lanjut
        if (!$kelompokIDs) {
            throw new \Exception('Seeder kelompok belum dijalankan atau ID tidak ditemukan.');
        }

        // Insert data sub_kelompok
        DB::table('sub_kelompok')->insert([
            // Fiksi //
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Novel',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Cerita Pendek',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Fiksi Ilmiah',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Fantasi',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Misteri/Detektif',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Non-Fiksi //
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Biografi dan Otobiografi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Sejarah',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Sains Teknologi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Sosial dan Politik',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Agama',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Pendidikan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Hobi dan Kerajinan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Kesehatan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Referensi //
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Ensiklopedia',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Kamus',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Atlas',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Laporan',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anak-Anak //
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Cerita Anak',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Buku Bergambar',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Edukasi',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buku Pelajaran Sekolah //
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Matematika',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Bahasa dan Sastra',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Ilmu Pengetahuan Sosial',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Ilmu Pengetahuan Alam',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Kesenian',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Str::uuid(),
                'nama' => 'Pelajaran Agama',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
