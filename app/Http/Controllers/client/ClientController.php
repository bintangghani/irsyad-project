<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Jenis;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $categories = Kelompok::with('buku')->get();

        $categories = $categories->map(function ($category) {
            $category->buku = $category->buku->take(8);
            return $category;
        });
        $trendingNavbar = Buku::where('total_read', '>', 0)->orderBy('total_read', 'desc')->take(4)->get();
        $trendingBooks = Buku::with(['jenis', 'sub_kelompok.kelompok', 'uploaded'])
            ->where('total_read', '>', 0)
            ->orderBy('total_read', 'desc')
            ->take(8)
            ->get();

        $newUploads = Buku::orderBy('created_at', 'desc')->take(8)->get();
        return view('pages.user.index', compact('trendingBooks', 'newUploads', 'categories', 'user', 'trendingNavbar'));
    }

    public function showBuku($id)
    {
        $buku = Buku::findOrFail($id);

        return view('pages.user.buku.show', compact('buku'));
    }

    public function category(Request $request)
    {
        $kelompoks = Kelompok::with(['buku', 'sub_kelompok.buku.uploaded'])->get();

        $selectedGenre = $request->genre;
        $selectedJenis = $request->jenis;

        $filteredCategories = $kelompoks->map(function ($kelompok) use ($selectedGenre, $selectedJenis) {
            $books = $kelompok->buku;

            if ($selectedJenis) {
                $books = $books->filter(function ($book) use ($selectedJenis) {
                    return $book->jenis === $selectedJenis;
                });
            }
            $books->load('uploaded');

            $kelompok->filteredBooks = $books;
            return $kelompok;
        });

        return view('pages.user.category.index', [
            'categories' => $filteredCategories,
            'genres' => Kelompok::pluck('nama'),
            'jenisList' => Jenis::pluck('nama'),
            'selectedGenre' => $selectedGenre,
            'selectedJenis' => $selectedJenis,
        ]);
    }
}
