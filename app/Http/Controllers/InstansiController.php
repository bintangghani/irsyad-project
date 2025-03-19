<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = Instansi::all();
        return view('pages.instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('pages.instansi.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:instansi,nama',
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'profile' => 'required|string|max:255',
                'background' => 'required|string|max:255'
            ]);

            Instansi::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'profile' => $request->profile,
                'background' => $request->background
            ]);

            return redirect()->route('dashboard.instansi.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $instansi = Instansi::find($request->id_instansi);

            if (!$instansi) {
                return response()->json('Instansi tidak ditemukan');
            }

            $instansi->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'profile' => $request->profile,
                'background' => $request->background
            ]);

            return redirect()->route('dashboard.instansi.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $instansi = Instansi::find($request->id_instansi);

            if (!$instansi) {
                return response()->json('Instansi tidak ditemukan');
            }

            $instansi->delete();

            return redirect()->route('dashboard.instansi.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }
}
