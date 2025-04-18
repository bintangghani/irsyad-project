<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Models\Jenis;
use App\Models\SubKelompok;

class CommonDataService
{
    public static function getCommonData($extraData = [],)
    {
        // Ambil filter dari request
        $selectedGenre = $extraData['genre'] ?? null;
        $selectedJenis = $extraData['jenisBuku'] ?? null;
        $selectedSubCategory = $extraData['sub_category'] ?? null;
        $selectedInstansi = $extraData['instansi'] ?? null;
        $selectedPenerbit = $extraData['penerbit'] ?? null;
        $search = $extraData['search'] ?? null;
        $trendingNavbar = Buku::where('total_read', '>', 0)->orderBy('total_read', 'desc')->take(4)->get();
        // Ambil data dasar untuk dropdown/filter
        $subGenres = SubKelompok::pluck('nama', 'id_sub_kelompok');
        $instansis = Instansi::pluck('nama', 'id_instansi');
        $penerbits = Buku::pluck('penerbit')->unique()->filter()->values(); // Hindari duplikat dan null
        $genres = Kelompok::pluck('nama');
        $jenisList = Jenis::pluck('nama', 'id_jenis');




        $showMostReadBooks = true;

        if (!$selectedGenre && !$selectedJenis && !$selectedSubCategory && !$selectedInstansi && !$selectedPenerbit && !$search) {
            $books = Buku::with('uploaded')
                ->orderByDesc('total_read')
                ->take(30)
                ->get();

            $categories = Kelompok::with(['sub_kelompok.buku.uploaded', 'sub_kelompok.buku.jenisBuku'])->get();
        } else {
            $showMostReadBooks = false;
            $kelompoks = Kelompok::with([
                'sub_kelompok.buku.uploaded',
                'sub_kelompok.buku.jenisBuku',
            ])->get();

            $categories = $kelompoks->map(function ($kelompok) use (
                $selectedGenre,
                $selectedJenis,
                $selectedSubCategory,
                $selectedInstansi,
                $selectedPenerbit,
                $search,
            ) {
                $books = $kelompok->sub_kelompok->flatMap(function ($sub) use (
                    $selectedGenre,
                    $selectedJenis,
                    $selectedSubCategory,
                    $selectedInstansi,
                    $selectedPenerbit,
                    $search,
                ) {
                    return $sub->buku->filter(function ($book) use (
                        $selectedGenre,
                        $selectedJenis,
                        $selectedSubCategory,
                        $selectedInstansi,
                        $selectedPenerbit,
                        $search,
                        $sub,
                    ) {

                        if ($selectedGenre && optional($sub->kelompok)->nama !== $selectedGenre) return false;
                        $jenisRelasi = $book->getRelationValue('jenis');
                        if ($selectedJenis && (!$jenisRelasi || $jenisRelasi->id_jenis !== $selectedJenis)) {
                            return false;
                        }
                        if ($selectedSubCategory && $book->sub_kelompok !== $selectedSubCategory) return false;
                        if ($selectedInstansi && $book->instansi_id !== $selectedInstansi) return false;
                        if  ($selectedPenerbit && $book->penerbit !== $selectedPenerbit) return false;
                        if ($search && stripos($book->judul, $search) === false) return false;

                        return true;
                    });
                });

                $kelompok->filteredBooks = $books;
                return $kelompok;
            });
        }

        $subcategories = SubKelompok::withCount('buku')
            ->orderByDesc('buku_count')
            ->take(6)
            ->get();

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
            'trendingNavbar'
        );

        return array_merge($commonData, $extraData);
    }
}