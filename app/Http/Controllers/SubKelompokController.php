<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\SubKelompok;
use Illuminate\Http\Request;

class SubKelompokController extends Controller
{
    public function index(Request $request)
    {
        $subkelompok = SubKelompok::with('kelompok');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $subkelompok->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($subkelompok->count() < 10) {
            $subkelompok = $subkelompok->orderBy('created_at', 'ASC')->paginate($subkelompok->count());
        } else {
            $subkelompok = $subkelompok->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.subkelompok.index', compact('subkelompok'));
    }

    public function create()
    {
        $subkelompok = SubKelompok::orderBy('created_at', 'ASC')->get();
        $kelompok = Kelompok::all();
        return view('pages.admin.subkelompok.create', compact('subkelompok', 'kelompok'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:sub_kelompok,nama',
                'id_kelompok' => 'required|exists:kelompok,id_kelompok'
            ]);

            SubKelompok::create([
                'nama' => $request->nama,
                'id_kelompok' => $request->id_kelompok
            ]);

            return redirect()->route('dashboard.buku.subkelompok.index')->with('success', 'SubKelompok berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $subkelompok = SubKelompok::findOrFail($id);
        $kelompok = Kelompok::all();
        return view('pages.admin.subkelompok.edit', compact('kelompok', 'subkelompok'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:sub_kelompok,nama,' . $id . ',id_sub_kelompok',
            ]);

            $subkelompok = SubKelompok::findOrFail($id);
            $subkelompok->update([
                'nama' => $request->nama,
            ]);

            return redirect()->route('dashboard.buku.subkelompok.index')->with('success', 'Sub Kelompok berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.buku.subkelompok.index')->with('error', 'Gagal memperbarui Sub Kelompok.');
        }
    }

    public function destroy($id)
    {
        try {
            $subkelompok = Subkelompok::findOrFail($id); // Pastikan data ada, jika tidak, lempar 404 error
            $subkelompok->delete();

            Alert::success('Success', 'Subkelompok berhasil dihapus');
            return redirect()->route('dashboard.buku.subkelompok.index');
        } catch (\Throwable $th) {
            Log::error('Error deleting subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus subkelompok.');
        }
    }


    public function search(Request $request)
    {
        $keyword = $request->search;
        $subkelompok = SubKelompok::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.subkelompok.index', compact('subkelompok'));
    }
}
