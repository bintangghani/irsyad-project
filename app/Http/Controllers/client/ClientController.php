<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Instansi;
use App\Models\Kelompok;
use App\Models\SubKelompok;
use App\Services\CommonDataService;
use Illuminate\Support\Facades\Auth;
use Log;
use RealRashid\SweetAlert\Facades\Alert;
use Storage;

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
        $trendingBooks = Buku::with(['jenisBuku', 'subKelompok', 'uploaded', 'subKelompok.kelompok'])
            ->where('total_read', '>', 0)
            ->orderBy('total_read', 'desc')
            ->take(8)
            ->get();

        $newUploads = Buku::with(['jenisBuku', 'subKelompok', 'uploaded', 'subKelompok.kelompok'])->orderBy('created_at', 'desc')->take(8)->get();
        return view('pages.user.index', compact('trendingBooks', 'newUploads', 'categories', 'user', 'trendingNavbar', 'subcategories'));
    }

    public function showBuku($id)
    {
        if(!haveAccessTo('show_buku_client')) {
            return redirect()->route('auth.login');
        }

        $buku = Buku::findOrFail($id);

        $categories = Kelompok::with('buku')->get();

        $categories = $categories->map(function($category) {
            $category->buku = $category->buku();
            return $category;
        });
        $subcategories = SubKelompok::withCount('buku')->orderByDesc('buku_count')->take(6)->get();
        $relatedBooks = Buku::where('sub_kelompok', $buku->sub_kelompok)->take(8)->get();
        $moreBy = Buku::where('penerbit', $buku->penerbit)->take(8)->get();

        return view('pages.user.buku.index', compact('buku', 'categories', 'relatedBooks','moreBy','subcategories'));
    }

    public function readBook($id) {
        if (!haveAccessTo('read_buku')) {
            return redirect()->route('auth.login');
        }

        $buku = Buku::findOrFail($id);
        
        $buku->increment('total_read');
        $buku->increment('total_download');

        return view('pages.user.buku.index', compact('buku', 'total_read', 'total_download'));
    }

    public function category(Request $request)
    {

        if (!haveAccessTo('show_category_client')) {
            return redirect()->route('auth.login');
        }

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
    

    public function instansi()
    {
        if (!haveAccessTo('show_instansi_client')) {
            return redirect()->route('auth.login');
        }
        return view(
            'pages.user.instansi.index',
            CommonDataService::getCommonData([
                'instansis' => Instansi::orderBy('nama')->get()
            ])
        );
    }

    public function showInstansi($id)
    {
        if (!haveAccessTo('show_instansi_client')) {
            return redirect()->route('auth.login');
        }
        return view('pages.user.instansi.show', CommonDataService::getCommonData([
            'instansi' => Instansi::findOrFail($id),
            'bukuInstansi' => Buku::with('uploaded')
                ->whereIn('uploaded_by', Instansi::findOrFail($id)->user()->pluck('id_user'))
                ->latest()
                ->get()
        ]));
    }

    public function profile()
    {
        if (!haveAccessTo('update_user_client')) {
            return redirect()->route('auth.login');
        }
        $categories = Kelompok::with('buku')->get();
        $subcategories = SubKelompok::withCount('buku')
        ->orderByDesc('buku_count')
        ->take(6)
        ->get();

        $categories = $categories->map(function($category) {
            $category->buku = $category->buku();
            return $category;
        });

        
        $user = Auth::user();
        return view('pages.user.profile.index', compact('user', 'categories', 'subcategories'));
    }

    public function editClientProfil($id)
    {
        if (!haveAccessTo('update_user_client')) {
            return redirect()->route('auth.login');
        }
        $user = User::findOrFail($id);
        return view('pages.user.profile.index', compact('user'));
    }

    public function updateClientProfile(Request $request,$id)
    {
        if (!haveAccessTo('update_user_client')) {
            return redirect()->route('auth.login');
        }
        try {
            $user = User::findOrFail($id);
            // dd($request->all());
            $request->validate([
               'nama' => 'required|string|max:255',
               'email' => 'required|string|email|max:255',
               'moto'=> 'nullable|string|max:255',
               'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            
            if ($request->hasFile('profile')) {
                if ($user->profile != 'assets/img/avatars/1.png') {
                    Storage::disk('public')->delete($user->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = $user->profile;
            }

            $user->update([
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'moto' => $request->input('moto'),
                'profile' => $profilePath,
            ]);
            Alert::success('Success', 'Profile berhasil diperbarui');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Error', 'Nampaknya terjadi kesalahan');
            Log::error($th);
            return redirect()->back();
        }
    }
}
