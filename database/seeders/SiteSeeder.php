<?php

namespace Database\Seeders;

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSettings::create([
            'id_site_settings' => Uuid::uuid4(),
            'icon' => '\assets\img\logo\logo_puskita.png',
            'title' => 'PUSKITA',
            'brand' => 'PUSKITA',
            'deskripsi' => 'Perpustakaan digital modern dengan koleksi buku terlengkap. Memberikan akses mudah untuk membaca dimana saja dan kapan saja.',
        ]);
    }
}
