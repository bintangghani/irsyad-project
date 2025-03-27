<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class JenisController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $jenis = Jenis::with('buku')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'LIKE', "%$search%");
            })
            ->orderBy('created_at', 'ASC')
            ->paginate($perPage);

        return view('pages.admin.jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('pages.admin.jenis.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:jenis,nama'
            ], [
                'nama.required' => 'Nama jenis wajib diisi!',
                'nama.string' => 'Nama jenis harus berupa teks!',
                'nama.max' => 'Nama jenis maksimal 255 karakter!',
                'nama.unique' => 'Nama jenis sudah terdaftar, gunakan nama lain!'
            ]);

            Jenis::create($validated);

            Alert::success('Success', 'Jenis berhasil ditambahkan');
            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            Log::error('Error storing Jenis: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function edit($id)
    {
        $jenis = Jenis::findOrFail($id);
        return view('pages.admin.jenis.edit', compact('jenis'));
    }

    public function update(Request $request, $id)
    {
        try {
            $jenis = Jenis::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:jenis,nama,' . $id . ',id_jenis'
            ], [
                'nama.required' => 'Nama jenis wajib diisi!',
                'nama.string' => 'Nama jenis harus berupa teks!',
                'nama.max' => 'Nama jenis maksimal 255 karakter!',
                'nama.unique' => 'Nama jenis sudah terdaftar, gunakan nama lain!'
            ]);

            $jenis->update($validated);

            Alert::success('Success', 'Jenis berhasil diperbarui');
            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            Log::error('Error updating Jenis: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }


    public function destroy(Request $request)
    {
        try {
            $jenis = Jenis::findOrFail($request->id_jenis);

            if (!$jenis->delete()) {
                return back()->withErrors(['error' => 'Gagal menghapus jenis.']);
            }

            Alert::success('Success', 'Jenis berhasil dihapus');
            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            Log::error('Error deleting Jenis: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }
}
