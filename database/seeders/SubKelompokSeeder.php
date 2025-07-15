<?php

namespace Database\Seeders;

use App\Models\SubKelompok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

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
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Novel',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Cerita Pendek',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Fiksi Ilmiah',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Fantasi',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Misteri/Detektif',
                'id_kelompok' => $kelompokIDs['Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Non-Fiksi //
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Biografi dan Otobiografi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Sejarah',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Sains Teknologi',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Sosial dan Politik',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Agama',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Pendidikan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Hobi dan Kerajinan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Kesehatan',
                'id_kelompok' => $kelompokIDs['Non-Fiksi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Referensi //
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Ensiklopedia',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Kamus',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Atlas',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Laporan',
                'id_kelompok' => $kelompokIDs['Referensi'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anak-Anak //
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Cerita Anak',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Buku Bergambar',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Edukasi',
                'id_kelompok' => $kelompokIDs['Anak-Anak'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Buku Pelajaran Sekolah //
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Matematika',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Bahasa dan Sastra',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Ilmu Pengetahuan Sosial',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Ilmu Pengetahuan Alam',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Kesenian',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_sub_kelompok' => Uuid::uuid4(),
                'nama' => 'Pelajaran Agama',
                'id_kelompok' => $kelompokIDs['Buku Pelajaran Sekolah'],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}