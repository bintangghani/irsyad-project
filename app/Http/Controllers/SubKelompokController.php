<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\SubKelompok;
use Illuminate\Http\Request;

class SubKelompokController extends Controller
{
    public function index()
    {
        $subkelompok = SubKelompok::with('kelompok')->get();
        $kelompok = Kelompok::all(); 

        return view('pages.admin.subkelompok.index', compact('subkelompok', 'kelompok'));
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

            return redirect()->route('dashboard.subkelompok.index')->with('success', 'SubKelompok berhasil ditambahkan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
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
    
            return redirect()->route('dashboard.subkelompok.index')->with('success', 'Sub Kelompok berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.subkelompok.index')->with('error', 'Gagal memperbarui Sub Kelompok.');
        }
    }

    public function destroy($id)
    {
        try {
            $subkelompok = SubKelompok::findOrFail($id);
            $subkelompok->delete();

            return redirect()->route('dashboard.subkelompok.index')->with('success', 'SubKelompok berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
