<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Services\CommonDataService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ClientController extends Controller
{
    public function index()
    {
        $data = CommonDataService::getCommonData([
            'user' => Auth::user(),
        ]);

        $data['trendingBooks'] = Buku::with(['jenisBuku', 'subKelompok', 'uploaded', 'subKelompok.kelompok'])
            ->where('total_read', '>', 0)->orderByDesc('total_read')->take(8)->get();

        $data['newUploads'] = Buku::with(['jenisBuku', 'subKelompok', 'uploaded', 'subKelompok.kelompok'])
            ->orderByDesc('created_at')->take(8)->get();

        $data['categories'] = Kelompok::with('buku')->get()->map(function ($cat) {
            $cat->buku = $cat->buku->take(8);
            return $cat;
        });

        return view('pages.user.index', $data);
    }


    public function showBuku($id)
    {
        $buku = Buku::with(['uploaded', 'jenisBuku', 'subKelompok.kelompok'])->findOrFail($id);
        $data = CommonDataService::getCommonData();

        $data['buku'] = $buku;
        $data['relatedBooks'] = $buku->subKelompok
            ? Buku::where('id_sub_kelompok', $buku->subKelompok->id_sub_kelompok)
            ->where('id_buku', '!=', $buku->id_buku)
            ->take(8)
            ->get()
            : collect();
        $data['moreBy'] = Buku::where('penerbit', $buku->penerbit)->take(8)->get();

        return view('pages.user.buku.index', $data);
    }


    public function readBook($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->increment('total_read');
        $buku->increment('total_download');

        return redirect()->route('client.showBuku', $id); // Hindari view langsung jika datanya sama dengan showBuku
    }


    public function category(Request $request)
    {
        $trendingBooks = Buku::with(['jenisBuku', 'subKelompok.kelompok', 'uploaded'])
            ->where('total_read', '>', 0)
            ->orderBy('total_read', 'desc')
            ->take(8)
            ->get();
        $filters = [
            'genre' => $request->genre,
            'jenisBuku' => $request->jenisBuku,
            'sub_category' => $request->sub_category,
            'instansi' => $request->instansi,
            'penerbit' => $request->penerbit,
            'search' => $request->search,
        ];

        $data = CommonDataService::getCommonData($filters);

        if ($data['showMostReadBooks']) {
            $books = $data['categories'][0]->filteredBooks ?? collect();
        } else {
            $books = $data['categories']->pluck('filteredBooks')->flatten();
        }

        return view('pages.user.category.index', array_merge($data, ['books' => $books], ['trendingBooks' => $trendingBooks]));
    }

    public function search(Request $request)
    {

        try {
            $keyword = $request->query('q');

            if (!$keyword) {
                return response()->json([], 200);
            }

            $books = Buku::where('judul', 'like', '%' . $keyword . '%')
                ->select('id_buku', 'judul')
                ->limit(10)
                ->get();

            return response()->json($books);
        } catch (\Exception $e) {
            Log::error("Search error: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
        }
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
        $instansi = Instansi::findOrFail($id);
        $users = $instansi->user()->pluck('id_user');

        return view('pages.user.instansi.show', CommonDataService::getCommonData([
            'instansi' => $instansi,
            'bukuInstansi' => Buku::with('uploaded')->whereIn('uploaded_by', $users)->latest()->get(),
        ]));
    }


    public function profile()
    {
        if (!haveAccessTo('update_user_client')) {
            return redirect()->route('auth.login');
        }

        $user = Auth::user();

        return view('pages.user.profile.index', CommonDataService::getCommonData([
            'user' => $user
        ]));
    }


    public function editClientProfil($id)
    {
        if (!haveAccessTo('update_user_client')) {
            return redirect()->route('auth.login');
        }
        $user = User::findOrFail($id);
        return view('pages.user.profile.index', compact('user'));
    }

    public function updateClientProfile(Request $request, $id)
    {
        if (!haveAccessTo('update_user_client')) return redirect()->route('auth.login');

        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'moto' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile')) {
            if ($user->profile != 'assets/img/avatars/1.png') {
                Storage::disk('public')->delete($user->profile);
            }
            $user->profile = $request->file('profile')->store('profiles', 'public');
        }

        $user->update($request->only(['nama', 'email', 'moto']) + ['profile' => $user->profile]);

        Alert::success('Success', 'Profile berhasil diperbarui');
        return redirect()->back();
    }
}
