<?php

namespace Database\Seeders;

use App\Models\SubKelompok;
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
        SubKelompok::insert([
            // Fiksi //
            [
                'nama' => 'Novel',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cerita Pendek',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fiksi Ilmiah',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Fantasi',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Misteri/Detektif',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Non-Fiksi //
            [
                'nama' => 'Biografi dan Otobiografi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sejarah',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sains Teknologi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Sosial dan Politik',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Agama',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pendidikan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Hobi dan Kerajinan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kesehatan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Referensi //
            [
                'nama' => 'Ensiklopedia',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kamus',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Atlas',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Laporan',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anak-Anak //
            [
                'nama' => 'Cerita Anak',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Buku Bergambar',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Edukasi',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buku Pelajaran Sekolah //
            [
                'nama' => 'Matematika',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Bahasa dan Sastra',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ilmu Pengetahuan Sosial',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ilmu Pengetahuan Alam',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kesenian',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pelajaran Agama',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
