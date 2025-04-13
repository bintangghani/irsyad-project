<?php

namespace App\Services;

use App\Models\Kelompok;
use App\Models\Jenis;

class CommonDataService
{
    public static function getCommonData($extraData = [])
    {
        // Mengambil kelompok dengan buku dan sub_kelompok terkait
        $kelompoks = Kelompok::with(['buku', 'sub_kelompok.buku.uploaded'])->get();

        // Menyaring kategori dan jenis berdasarkan filter
        $selectedGenre = request()->get('genre');
        $selectedJenis = request()->get('jenis');

        // Filter buku berdasarkan jenis dan genre
        $filteredCategories = $kelompoks->map(function ($kelompok) use ($selectedGenre, $selectedJenis) {
            $books = $kelompok->buku;

            // Filter berdasarkan jenis
            if ($selectedJenis) {
                $books = $books->filter(function ($book) use ($selectedJenis) {
                    return $book->jenis === $selectedJenis;
                });
            }

            // Filter berdasarkan genre
            if ($selectedGenre) {
                $books = $books->filter(function ($book) use ($selectedGenre) {
                    return $book->genre === $selectedGenre;
                });
            }

            $books->load('uploaded');

            $kelompok->filteredBooks = $books;
            return $kelompok;
        });

        // Mengambil list genre dan jenis untuk ditampilkan pada view
        $genres = Kelompok::pluck('nama');
        $jenisList = Jenis::pluck('nama');
        $categories = $filteredCategories;

        // Menyatukan data umum
        $commonData = compact('categories', 'genres', 'jenisList', 'selectedGenre', 'selectedJenis');

        return array_merge($commonData, $extraData);
    }
}