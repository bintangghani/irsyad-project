<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $kelompok = Kelompok::with('sub_kelompok')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate($perPage);

        return view('pages.admin.kelompok.index', compact('kelompok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.kelompok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:kelompok,nama'
            ], [
                'nama.required' => 'Nama kelompok wajib diisi!',
                'nama.string' => 'Nama kelompok harus berupa teks!',
                'nama.max' => 'Nama kelompok maksimal 255 karakter!',
                'nama.unique' => 'Nama kelompok sudah terdaftar, gunakan nama lain!'
            ]);

            Kelompok::create($validated);

            Alert::success('Success', 'Kelompok berhasil ditambahkan');
            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            Log::error('Error storing kelompok: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelompok = Kelompok::findOrFail($id);
        return view('pages.admin.kelompok.edit', compact('kelompok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $kelompok = Kelompok::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:kelompok,nama,' . $id . ',id_kelompok'
            ], [
                'nama.required' => 'Nama kelompok wajib diisi!',
                'nama.string' => 'Nama kelompok harus berupa teks!',
                'nama.max' => 'Nama kelompok maksimal 255 karakter!',
                'nama.unique' => 'Nama kelompok sudah terdaftar, gunakan nama lain!'
            ]);

            $kelompok->update($validated);

            Alert::success('Success', 'Kelompok berhasil diperbarui');
            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            Log::error('Error updating kelompok: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $kelompok = Kelompok::findOrFail($request->id_kelompok);

            if (!$kelompok->delete()) {
                return back()->withErrors(['error' => 'Gagal menghapus kelompok.']);
            }

            Alert::success('Success', 'Kelompok berhasil dihapus');
            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            Log::error('Error deleting kelompok: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $kelompok = Kelompok::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.kelompok.index', compact('kelompok'));
    }
}
