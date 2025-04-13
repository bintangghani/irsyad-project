<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Models\SubKelompok;
use App\Services\CommonDataService;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Kelompok::with('buku')->get();
        $subcategories = SubKelompok::withCount('buku')
            ->orderByDesc('buku_count')
            ->take(6)
            ->get();
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
        return view('pages.user.index', compact('trendingBooks', 'newUploads', 'categories', 'user', 'trendingNavbar', 'subcategories'));
    }

    public function showBuku($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.user.buku.index', compact('buku'));
    }

    public function category()
    {
        return view('pages.user.category.index', CommonDataService::getCommonData([]));
    }

    public function instansi()
    {
        return view(
            'pages.user.instansi.index',
            CommonDataService::getCommonData([
                'instansis' => Instansi::orderBy('nama')->get()
            ])
        );
    }

    public function showInstansi($id)
    {
        return view('pages.user.instansi.show', CommonDataService::getCommonData([
            'instansi' => Instansi::findOrFail($id),
            'bukuInstansi' => Buku::with('uploaded')
                ->whereIn('uploaded_by', Instansi::findOrFail($id)->user()->pluck('id_user'))
                ->latest()
                ->get()
        ]));
    }
}
