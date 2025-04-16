<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Models\Bookmark;
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
        $buku = Buku::with(['uploaded', 'subKelompok', 'jenisBuku']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $buku->where('judul', 'LIKE', "%$search%");
        }

        $totalData = $buku->count();
        $perPage = $request->input('per_page', 10);
        $buku = $buku->orderBy('created_at', 'ASC')->paginate(min($totalData, $perPage));

        // dd($buku);
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
        $book = Buku::findOrFail($id);
        $book->increment('total_read');
        return view('pages.user.buku.show', compact('book'));
    }

    public function edit(string $id)
    {
        if (!haveAccessTo('update_buku')) {
            return redirect()->back();
        }
        // $buku = Buku::findOrFail($id);
        $buku = $this->bukuRepository->find($id);
        $subkelompok = $this->subKelompokRepository->all();
        $jenis = $this->jenisRepository->all();
        // $user = $this->userRepository->all();

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

            if ($request->hasFile('sampul')) {
                Storage::disk('public')->delete($buku->sampul);
                $validated['sampul'] = $request->file('sampul')->store('sampuls', 'public');
            } else {
                $validated['sampul'] = $buku->sampul;
            }

            if ($request->hasFile('file_buku')) {
                Storage::disk('public')->delete($buku->file_buku);
                $validated['file_buku'] = $request->file('file_buku')->store('buku', 'public');
            } else {
                $validated['file_buku'] = $buku->file_buku;
            }

            $buku->update($validated);

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
}
