<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompok = Kelompok::all();
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
            $request->validate([
                'nama' => 'required|string|max:255|unique:kelompok,nama'
            ]);

            Kelompok::create([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $kelompok = Kelompok::find($request->id_jenis);

            if (!$kelompok) {
                return response()->json('Kelompok tidak ditemukan');
            }

            $kelompok->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $kelompok = Kelompok::find($request->id_kelompok);

            if (!$kelompok) {
                return response()->json('Kelompok tidak ditemukan');
            }

            $kelompok->delete();

            return redirect()->route('dashboard.kelompok.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
