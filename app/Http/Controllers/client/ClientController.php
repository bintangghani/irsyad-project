<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kelompok;

class ClientController extends Controller
{
    public function index()
    {
        $categories = Kelompok::with('buku')->get();

        $categories = $categories->map(function ($category) {
            $category->buku = $category->buku->take(8);
            return $category;
        });
        $trendingBooks = Buku::where('total_read', '>', 0)->orderBy('total_read', 'desc')->take(8)->get();
        $newUploads = Buku::orderBy('created_at', 'desc')->take(8)->get();
        return view('pages.user.index', compact('trendingBooks', 'newUploads', 'categories'));
    }

    public function showBuku($id)
    {
        $buku = Buku::findOrFail($id);

        return view('pages.user.buku.show', compact('buku'));
    }

    public function category()
    {
        $categories = Kelompok::with('buku')->get();

        // Batasi hanya 8 buku per kategori
        $categories = $categories->map(function ($category) {
            $category->buku = $category->buku->take(8);
            return $category;
        });

        return view('pages.user.category.index', compact('categories'));
    }
}
