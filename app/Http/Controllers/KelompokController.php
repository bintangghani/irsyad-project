<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use Illuminate\Http\Request;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelompok = Kelompok::with('sub_kelompok');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $kelompok->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);
        
        if ($kelompok->count() < 10) {
            $kelompok = $kelompok->orderBy('created_at', 'ASC')->paginate($kelompok->count());
        } else {
            $kelompok = $kelompok->orderBy('created_at', 'ASC')->paginate($perPage);
        }
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

    public function search(Request $request)
    {
        $keyword = $request->search;
        $kelompok = Kelompok::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.kelompok.index', compact('kelompok'));
    }
}
