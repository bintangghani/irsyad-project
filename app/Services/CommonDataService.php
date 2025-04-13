<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Models\Jenis;
use App\Models\SubKelompok;
use App\Models\User;

class CommonDataService
{
    public static function getCommonData($extraData = [])
    {
        $kelompoks = Kelompok::with(['buku', 'sub_kelompok.buku.uploaded'])->get();

        // Ambil filter dari request
        $selectedGenre = request()->get('genre');
        $selectedJenis = request()->get('jenis');
        $selectedSubCategory = request()->get('sub_category');
        $selectedInstansi = request()->get('instansi');
        $selectedPenerbit = request()->get('penerbit');
        $search = request()->get('search');

        // Ambil data dasar untuk dropdown/filter
        $subGenres = SubKelompok::pluck('nama', 'id_sub_kelompok');
        $instansis = Instansi::pluck('nama', 'id_instansi');
        $penerbits = buku::pluck( 'penerbit');
        $genres = Kelompok::pluck('nama');
        $jenisList = Jenis::pluck('nama');

        // Filter buku dalam setiap kelompok
        $filteredCategories = $kelompoks->map(function ($kelompok) use (
            $selectedGenre,
            $selectedJenis,
            $selectedSubCategory,
            $selectedInstansi,
            $selectedPenerbit,
            $search,
        ) {
            $books = $kelompok->buku;

            if ($selectedJenis) {
                $books = $books->where('jenis', $selectedJenis);
            }

            if ($selectedGenre) {
                $books = $books->where('genre', $selectedGenre);
            }

            if ($selectedSubCategory) {
                $books = $books->where('id_sub_kelompok', $selectedSubCategory);
            }

            if ($selectedInstansi) {
                $books = $books->where('instansi_id', $selectedInstansi); 
            }

            if ($selectedPenerbit) {
                $books = $books->where('penerbit_id', $selectedPenerbit); 
            }

            if ($search) {
                $books = $books->filter(function ($book) use ($search) {
                    return stripos($book->judul, $search) !== false;
                });
            }

            $books->load('uploaded');

            $kelompok->filteredBooks = $books;
            return $kelompok;
        });

        $subcategories = SubKelompok::withCount('buku')
            ->orderByDesc('buku_count')
            ->take(6)
            ->get();

        $categories = $filteredCategories;

        $commonData = compact(
            'categories',
            'genres',
            'jenisList',
            'selectedGenre',
            'selectedSubCategory',
            'selectedInstansi',
            'selectedJenis',
            'subGenres',
            'subcategories',
            'instansis',
            'penerbits',
            'search'
        );

        return array_merge($commonData, $extraData);
    }
}
