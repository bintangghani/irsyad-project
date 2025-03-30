<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\SubKelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buku = Buku::with(['uploaded', 'sub_kelompok', 'jenis']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $buku->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($buku->count() < 10) {
            $buku = $buku->orderBy('created_at', 'ASC')->paginate($buku->count());
        } else {
            $buku = $buku->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        // dd($buku->toArray());

        return view('pages.admin.buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subkelompok = SubKelompok::all();
        $jenis = Jenis::all();
        $user = User::all();
        return view('pages.admin.buku.create', compact('subkelompok', 'jenis', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'penerbit' => 'required|string|max:255',
                'alamat_penerbit' => 'required|string|max:255',
                'judul' => 'required|string|max:255',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'jumlah_halaman' => 'required|integer',
                'sampul' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'deskripsi' => 'required|string',
                'file_buku' => 'nullable|file|mimes:pdf|max:10240',
                'total_download' => 'integer|min:0',
                'total_read' => 'integer|min:0',
                'uploaded_by' => 'required|uuid|exists:users,id_user',
                'sub_kelompok' => 'required|uuid|exists:sub_kelompok,id_sub_kelompok',
                'jenis' => 'required|uuid|exists:jenis,id_jenis',
            ]);

            $sampulPath = $request->file('sampul')->store('sampuls', 'public');
            $bukuPath = $request->file('file_buku')->store('buku', 'public');

            Buku::create([
                'penerbit' => $request->penerbit,
                'alamat_penerbit' => $request->alamat_penerbit,
                'judul' => $request->judul,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah_halaman' => $request->jumlah_halaman,
                'sampul' => $sampulPath,
                'deskripsi' => $request->deskripsi,
                'file_buku' => $bukuPath,
                'total_download' => $request->total_download ?? 0,
                'total_read' => $request->total_read ?? 0,
                'uploaded_by' => $request->uploaded_by,
                'sub_kelompok' => $request->sub_kelompok,
                'jenis' => $request->jenis,
            ]);

            return redirect()->route('dashboard.buku.index')->with('success', 'Buku berhasil ditambah!');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $book = Buku::findOrFail($id);
    
        
        $book->increment('total_read');
    
        return view('pages.user.buku.show', compact('book'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $subkelompok = SubKelompok::all();
        $jenis = Jenis::all();
        return view('pages.admin.buku.edit', compact('subkelompok', 'jenis', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $buku = Buku::findOrFail($id);

            // Validasi input
            $request->validate([
                'penerbit' => 'required|string|max:255',
                'alamat_penerbit' => 'required|string|max:255',
                'judul' => 'required|string|max:255',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'jumlah_halaman' => 'required|integer',
                'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'deskripsi' => 'required|string',
                'file_buku' => 'nullable|file|mimes:pdf|max:10240',
                'total_download' => 'integer|min:0',
                'total_read' => 'integer|min:0',
                'uploaded_by' => 'required|uuid|exists:users,id_user',
                'sub_kelompok' => 'required|uuid|exists:sub_kelompok,id_sub_kelompok',
                'jenis' => 'required|uuid|exists:jenis,id_jenis',
            ]);

            // Update Sampul
            if ($request->hasFile('sampul')) {
                if ($buku->sampul) {
                    Storage::disk('public')->delete($buku->sampul);
                }
                $sampulPath = $request->file('sampul')->store('sampuls', 'public');
            } else {
                $sampulPath = $buku->sampul;
            }

            // Update File Buku
            if ($request->hasFile('file_buku')) {
                if ($buku->file_buku) {
                    Storage::disk('public')->delete($buku->file_buku);
                }
                $bukuPath = $request->file('file_buku')->store('buku', 'public');
            } else {
                $bukuPath = $buku->file_buku;
            }

            // Update data buku
            $updated = $buku->update([
                'penerbit' => $request->penerbit,
                'alamat_penerbit' => $request->alamat_penerbit,
                'judul' => $request->judul,
                'tahun_terbit' => $request->tahun_terbit,
                'jumlah_halaman' => $request->jumlah_halaman,
                'sampul' => $sampulPath,
                'deskripsi' => $request->deskripsi,
                'file_buku' => $bukuPath,
                'total_download' => $request->total_download ?? 0,
                'total_read' => $request->total_read ?? 0,
                'uploaded_by' => $request->uploaded_by,
                'sub_kelompok' => $request->sub_kelompok,
                'jenis' => $request->jenis,
            ]);

            if (!$updated) {
                return back()->with('error', 'Gagal memperbarui buku.');
            }

            return redirect()->route('dashboard.buku.index')->with('success', 'Buku berhasil diperbarui!');
        } catch (\Throwable $th) {
            Log::error('Update Buku Error: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $buku = Buku::find($request->id_buku);

            if (!$buku) {
                return response()->json('Buku tidak ditemukan');
            }

            $buku->delete();

            return redirect()->route('dashboard.buku.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $buku = Buku::where('judul', 'like', "%$keyword%")->get();

        return view('pages.admin.buku.index', compact('buku'));
    }
}
