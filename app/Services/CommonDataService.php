<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Models\Jenis;
use App\Models\SiteSettings;
use App\Models\SubKelompok;

class CommonDataService
{
    public static function getCommonData(array $extraData = [])
    {
        $selectedGenre       = $extraData['genre'] ?? null;
        $selectedJenis       = $extraData['jenisBuku'] ?? null;
        $selectedSubCategory = $extraData['sub_category'] ?? null;
        $selectedInstansi    = $extraData['instansi'] ?? null;
        $selectedPenerbit    = $extraData['penerbit'] ?? null;
        $search              = $extraData['search'] ?? null;

        $showMostReadBooks = !$selectedGenre && !$selectedJenis && !$selectedSubCategory && !$selectedInstansi && !$selectedPenerbit && !$search;

        $categories = Kelompok::with([
            'sub_kelompok.buku' => function ($query) use (
                $selectedGenre,
                $selectedJenis,
                $selectedSubCategory,
                $selectedInstansi,
                $selectedPenerbit,
                $search
            ) {
                $query->with(['uploaded', 'jenisBuku'])
                    ->when($selectedJenis, fn($q) => $q->where('id_jenis', $selectedJenis))
                    ->when($selectedSubCategory, fn($q) => $q->where('sub_kelompok', $selectedSubCategory))
                    ->when($selectedInstansi, fn($q) => $q->where('instansi_id', $selectedInstansi))
                    ->when($selectedPenerbit, fn($q) => $q->where('penerbit', $selectedPenerbit))
                    ->when($search, fn($q) => $q->where('judul', 'like', '%' . $search . '%'));
            },
            'sub_kelompok.kelompok'
        ])->get()->map(function ($kelompok) {
            $kelompok->filteredBooks = $kelompok->sub_kelompok->flatMap(function ($sub) {
                return $sub->buku;
            });
            return $kelompok;
        });


        if ($selectedGenre) {
            $categories = $categories->filter(fn($kelompok) => $kelompok->nama === $selectedGenre);
        }

        // Data tambahan
        $subcategories   = SubKelompok::withCount('buku')->orderByDesc('buku_count')->take(6)->get();
        $trendingNavbar  = Buku::orderByDesc('total_read')->take(4)->get();
        $subGenres       = SubKelompok::pluck('nama', 'id_sub_kelompok');
        $instansis       = Instansi::pluck('nama', 'id_instansi');
        $penerbits       = Buku::whereNotNull('penerbit')->distinct()->pluck('penerbit');
        $genres          = Kelompok::pluck('nama');
        $jenisList       = Jenis::pluck('nama', 'id_jenis');
        $setting         = SiteSettings::first();

        $commonData = compact(
            'categories',
            'genres',
            'jenisList',
            'selectedGenre',
            'selectedSubCategory',
            'selectedInstansi',
            'selectedJenis',
            'selectedPenerbit',
            'subGenres',
            'subcategories',
            'instansis',
            'penerbits',
            'showMostReadBooks',
            'search',
            'trendingNavbar',
            'setting'
        );

        return array_merge($commonData, $extraData);
    }
}
