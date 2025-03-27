<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index(Request $request)
    {
        $jenis = Jenis::with('buku');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $jenis->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($jenis->count() < 10) {
            $jenis = $jenis->orderBy('created_at', 'ASC')->paginate($jenis->count());
        } else {
            $jenis = $jenis->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('pages.admin.jenis.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:jenis,nama'
            ]);

            Jenis::create([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $jenis = Jenis::find($request->id_jenis);

            if (!$jenis) {
                return response()->json('Jenis tidak ditemukan');
            }

            $jenis->update([
                'nama' => $request->nama
            ]);

            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $jenis = Jenis::find($request->id_jenis);

            if (!$jenis) {
                return response()->json('Jenis tidak ditemukan');
            }

            $jenis->delete();

            return redirect()->route('dashboard.jenis.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $jenis = Jenis::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.jenis.index', compact('jenis'));
    }
}
