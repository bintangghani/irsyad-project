<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\SubKelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

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
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:sub_kelompok,nama',
                'id_kelompok' => 'required|exists:kelompok,id_kelompok'
            ], [
                'nama.required' => 'Nama subkelompok wajib diisi!',
                'nama.string' => 'Nama subkelompok harus berupa teks!',
                'nama.max' => 'Nama subkelompok maksimal 255 karakter!',
                'nama.unique' => 'Nama subkelompok sudah terdaftar, gunakan nama lain!',
                'id_kelompok.required' => 'Kelompok wajib dipilih!',
                'id_kelompok.exists' => 'Kelompok yang dipilih tidak valid!'
            ]);

            SubKelompok::create($validated);

            return redirect()->route('dashboard.buku.subkelompok.index')
                ->with('success', 'SubKelompok berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Error storing subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
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
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:sub_kelompok,nama,' . $id . ',id_sub_kelompok',
                'id_kelompok' => 'required|exists:kelompok,id_kelompok'
            ], [
                'nama.required' => 'Nama Subkelompok wajib diisi!',
                'nama.string' => 'Nama subkelompok harus berupa teks!',
                'nama.max' => 'Nama subkelompok maksimal 255 karakter!',
                'nama.unique' => 'Nama subkelompok sudah terdaftar, gunakan nama lain!',
                'id_kelompok.required' => 'Kelompok wajib dipilih!',
                'id_kelompok.exists' => 'Kelompok yang dipilih tidak valid!'
            ]);

            $subkelompok = SubKelompok::findOrFail($id);
            $subkelompok->update([
                'nama' => $validated['nama'],
                'id_kelompok' => $validated['id_kelompok']
            ]);

            return redirect()->route('dashboard.buku.subkelompok.index')
                ->with('success', 'Sub Kelompok berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Error updating subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $subkelompok = SubKelompok::find($request->id_sub_kelompok);

            if (!$subkelompok) {
                return response()->json('Sub Kelompok tidak ditemukan');
            }

            $subkelompok->delete();

            return redirect()->route('dashboard.buku.subkelompok.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $subkelompok = SubKelompok::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.subkelompok.index', compact('subkelompok'));
    }
}
