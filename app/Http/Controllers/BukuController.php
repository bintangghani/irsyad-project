<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Imports\BukuImport;
use App\Models\Buku;
use App\Models\Bookmark;
use App\Models\User;
use App\Repositories\BukuRepository\BukuRepositoryInterface;
use App\Repositories\JenisRepository\JenisRepositoryInterface;
use App\Repositories\SubKelompokRepository\SubKelompokRepositoryInterface;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    public function __construct(
        protected BukuRepositoryInterface $bukuRepository,
        protected SubKelompokRepositoryInterface $subKelompokRepository,
        protected JenisRepositoryInterface $jenisRepository,
        protected UserRepositoryInterface $userRepository
    ) {}

    public function index(Request $request)
    {
        if (!haveAccessTo('create_buku')) {
            return redirect()->back();
        }

        $buku = Buku::with(['uploaded', 'subKelompok.kelompok', 'jenisBuku']);
        $role = Auth::user()->role->nama;

        $user = Auth::user();

        if ($role !== 'superadmin') {
            if ($user->id_instansi) {
                $userInstansiIds = User::where('id_instansi', $user->id_instansi)->pluck('id_user');
                $buku->whereIn('uploaded_by', $userInstansiIds);
            } else {
                $buku->where('uploaded_by', $user->id_user);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $buku->where('judul', 'LIKE', "%$search%");
        }

        $totalData = $buku->count();
        $perPage = $request->input('per_page', 10);
        $buku = $buku->orderBy('created_at', 'ASC')->paginate(min($totalData, $perPage));

        return view('pages.admin.buku.index', compact('buku'));
    }


    public function create()
    {
        if (!haveAccessTo('create_buku')) {
            return redirect()->back();
        }
        $subkelompok = $this->subKelompokRepository->all();
        $jenis = $this->jenisRepository->all();
        $user = $this->userRepository->all();

        return view('pages.admin.buku.create', compact('subkelompok', 'jenis', 'user'));
    }

    public function store(BukuRequest $request)
    {
        if (!haveAccessTo('create_buku')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $sampulPath = $request->file('sampul')->store('sampuls', 'public');
            $bukuPath = $request->hasFile('file_buku')
                ? $request->file('file_buku')->store('buku', 'public')
                : null;

            Buku::create([
                ...$validated,
                'sampul' => $sampulPath,
                'file_buku' => $bukuPath,
                'total_download' => $validated['total_download'] ?? 0,
                'total_read' => $validated['total_read'] ?? 0,
            ]);

            DB::commit();
            Alert::success('Success', 'Buku berhasil ditambahkan');
            return redirect()->route('dashboard.buku.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Store Buku Error: ' . $th->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function show($id)
    {
        $role = Auth::user()->role->nama;
        $user = Auth::user();

        $book = Buku::findOrFail($id);
        $book->increment('total_read');

        $bukuInstansi = $role === 'admin instansi'
            ? Buku::whereIn('uploaded_by', User::where('id_instansi', $user->id_instansi)->pluck('id_user'))
            ->count()
            : Buku::count();

        return view('pages.user.buku.show', compact('book'));
    }

    public function edit(string $id)
    {
        if (!haveAccessTo('update_buku')) {
            return redirect()->back();
        }

        $buku           = $this->bukuRepository->find($id);
        $subkelompok    = $this->subKelompokRepository->all();
        $jenis          = $this->jenisRepository->all();

        return view('pages.admin.buku.edit', compact('subkelompok', 'jenis', 'buku'));
    }

    public function update(BukuRequest $request, $id)
    {
        if (!haveAccessTo('update_buku')) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $buku = Buku::findOrFail($id);

            // Default path lama
            $validated['sampul'] = $buku->sampul;
            if ($request->hasFile('sampul')) {
                Storage::disk('public')->delete($buku->sampul);
                $validated['sampul'] = $request->file('sampul')->store('sampuls', 'public');
            }

            $validated['file_buku'] = $buku->file_buku;
            if ($request->hasFile('file_buku')) {
                Storage::disk('public')->delete($buku->file_buku);
                $validated['file_buku'] = $request->file('file_buku')->store('buku', 'public');
            }

            $this->bukuRepository->update($id, $validated);

            DB::commit();
            Alert::success('Success', 'Buku berhasil diperbarui');
            return redirect()->route('dashboard.buku.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Update Buku Error: ' . $th->getMessage());
            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function destroy($id)
    {
        if (!haveAccessTo('delete_buku')) {
            return redirect()->back();
        }
        // $buku = Buku::findOrFail($id);
        $buku = $this->bukuRepository->find($id);
        $buku->delete();
        Alert::success('Success', 'Buku berhasil dihapus');
        return redirect()->route('dashboard.buku.index');
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_buku')) {
            return redirect()->back();
        }
        $keyword = $request->search;
        $buku = Buku::where('judul', 'like', "%$keyword%")->get();
        return view('pages.admin.buku.index', compact('buku'));
    }

    public function read($id)
    {
        try {
            $user = Auth::user();
            $buku = Buku::findOrFail($id);

            $alreadyRead = Bookmark::where('id_user', $user->id_user)
                ->where('id_buku', $buku->id_buku)
                ->exists();

            if (!$alreadyRead) {
                $buku->increment('total_read');
                Bookmark::create([
                    'id_user' => $user->id_user,
                    'id_buku' => $buku->id_buku,
                ]);
            }

            return view('pages.user.buku.bookmarks', compact('buku'));
        } catch (\Throwable $th) {
            Log::error('Read Buku Error: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membaca buku.']);
        }
    }

    public function importForm()
    {
        return view('pages.admin.buku.import');
    }

    public function import(Request $request)
    {
        if (!haveAccessTo('import_buku')) {
            return redirect()->back();
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new BukuImport($this->bukuRepository);
            Excel::import($import, $request->file('file'));
            Alert::success('Berhasil', 'Data buku berhasil diimpor.');
            return redirect()->route('dashboard.buku.index');
        } catch (\Throwable $th) {
            Alert::error('Gagal', 'Import buku gagal. Periksa format atau data duplikat.');
            Log::error('Import error: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data.');
        }
    }
}
