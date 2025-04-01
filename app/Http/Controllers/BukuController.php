<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Jenis;
use App\Models\SubKelompok;
use App\Models\User;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

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
            $buku->where('judul', 'LIKE', "%$search%");
        }

        $totalData = $buku->count();
        $perPage = $request->input('per_page', 10);
        $buku = $buku->orderBy('created_at', 'ASC')->paginate($perPage);
        // Debugging untuk melihat struktur data
        // dd($buku->first()->toArray());

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
            $validated = $request->validate([
                'penerbit' => 'required|string|max:255',
                'alamat_penerbit' => 'required|string|max:255',
                'judul' => 'required|string|max:255|unique:buku,judul',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'jumlah_halaman' => 'required|integer|min:1',
                'sampul' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'deskripsi' => 'required|string',
                'file_buku' => 'nullable|file|mimes:pdf|max:10240',
                'total_download' => 'nullable|integer|min:0',
                'total_read' => 'nullable|integer|min:0',
                'uploaded_by' => 'required|uuid|exists:users,id_user',
                'sub_kelompok' => 'required|uuid|exists:sub_kelompok,id_sub_kelompok',
                'jenis' => 'required|uuid|exists:jenis,id_jenis',
            ], [
                'judul.unique' => 'Judul buku sudah terdaftar, gunakan judul lain!',
                'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 angka!',
                'jumlah_halaman.min' => 'Jumlah halaman harus lebih dari 0!',
                'sampul.required' => 'Sampul wajib diunggah!',
                'sampul.image' => 'File sampul harus berupa gambar!',
                'file_buku.mimes' => 'File buku harus dalam format PDF!',
            ]);

            // Simpan sampul buku
            $sampulPath = $request->file('sampul')->store('sampuls', 'public');

            // Simpan file buku jika ada
            $bukuPath = $request->hasFile('file_buku')
                ? $request->file('file_buku')->store('buku', 'public')
                : null;

            Buku::create([
                'penerbit' => $validated['penerbit'],
                'alamat_penerbit' => $validated['alamat_penerbit'],
                'judul' => $validated['judul'],
                'tahun_terbit' => $validated['tahun_terbit'],
                'jumlah_halaman' => $validated['jumlah_halaman'],
                'sampul' => $sampulPath,
                'deskripsi' => $validated['deskripsi'],
                'file_buku' => $bukuPath,
                'total_download' => $validated['total_download'] ?? 0,
                'total_read' => $validated['total_read'] ?? 0,
                'uploaded_by' => $validated['uploaded_by'],
                'sub_kelompok' => $validated['sub_kelompok'],
                'jenis' => $validated['jenis'],
            ]);

            Alert::success('Success', 'Buku berhasil ditambahkan');
            return redirect()->route('dashboard.buku.index')->with('success', 'Buku berhasil ditambah!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $th) {
            Log::error('Error storing buku: ' . $th->getMessage());
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.user.buku.index', compact('buku'));
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

            $validated = $request->validate([
                'penerbit' => 'required|string|max:255',
                'alamat_penerbit' => 'required|string|max:255',
                'judul' => 'required|string|max:255|unique:buku,judul,' . $id . ',id_buku',
                'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'jumlah_halaman' => 'required|integer|min:1',
                'sampul' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
                'deskripsi' => 'required|string',
                'file_buku' => 'nullable|file|mimes:pdf|max:10240',
                'total_download' => 'nullable|integer|min:0',
                'total_read' => 'nullable|integer|min:0',
                'uploaded_by' => 'required|uuid|exists:users,id_user',
                'sub_kelompok' => 'required|uuid|exists:sub_kelompok,id_sub_kelompok',
                'jenis' => 'required|uuid|exists:jenis,id_jenis',
            ], [
                'judul.unique' => 'Judul buku sudah digunakan, silakan pilih judul lain!',
                'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 angka!',
                'jumlah_halaman.min' => 'Jumlah halaman harus lebih dari 0!',
                'sampul.mimes' => 'Format gambar yang diperbolehkan: jpeg, png, jpg!',
                'file_buku.mimes' => 'File buku harus dalam format PDF!',
            ]);

            if ($request->hasFile('sampul')) {
                if ($buku->sampul) {
                    Storage::disk('public')->delete($buku->sampul);
                }
                $sampulPath = $request->file('sampul')->store('sampuls', 'public');
            } else {
                $sampulPath = $buku->sampul;
            }

            if ($request->hasFile('file_buku')) {
                if ($buku->file_buku) {
                    Storage::disk('public')->delete($buku->file_buku);
                }
                $bukuPath = $request->file('file_buku')->store('buku', 'public');
            } else {
                $bukuPath = $buku->file_buku;
            }

            $updated = $buku->update([
                'penerbit' => $validated['penerbit'],
                'alamat_penerbit' => $validated['alamat_penerbit'],
                'judul' => $validated['judul'],
                'tahun_terbit' => $validated['tahun_terbit'],
                'jumlah_halaman' => $validated['jumlah_halaman'],
                'sampul' => $sampulPath,
                'deskripsi' => $validated['deskripsi'],
                'file_buku' => $bukuPath,
                'total_download' => $validated['total_download'] ?? $buku->total_download,
                'total_read' => $validated['total_read'] ?? $buku->total_read,
                'uploaded_by' => $validated['uploaded_by'],
                'sub_kelompok' => $validated['sub_kelompok'],
                'jenis' => $validated['jenis'],
            ]);

            if (!$updated) {
                return back()->with('error', 'Gagal memperbarui buku.');
            }

            Alert::success('Success', 'Buku berhasil diperbarui');
            return redirect()->route('dashboard.buku.index')->with('success', 'Buku berhasil diperbarui!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Throwable $th) {
            Log::error('Update Buku Error: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::find($id);

        $buku->delete();

        Alert::success('Success', 'Buku berhasil dihapus');

        return redirect()->route('dashboard.buku.index');
    }

    public function search(Request $request)
    {
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
                'id_buku' => $buku->id_buku
            ]);
        }

        return view('pages.user.buku.bookmarks', compact('buku'));
        } catch (\Throwable $th) {
            Log::error('Read Buku Error: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membaca buku.']);
        }
        
    }
}
