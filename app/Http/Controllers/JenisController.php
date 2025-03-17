<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
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
}
