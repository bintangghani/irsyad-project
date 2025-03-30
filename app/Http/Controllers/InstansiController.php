<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $instansi = Instansi::with('user');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $instansi->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%");
                $q->where('role', 'LIKE', "%$search%");
                $q->where('instansi', 'LIKE', "%$search%");
            });
        }

        $perPage = $request->input('per_page', 10);

        if ($instansi->count() < 10) {
            $instansi = $instansi->orderBy('created_at', 'ASC')->paginate($instansi->count());
        } else {
            $instansi = $instansi->orderBy('created_at', 'ASC')->paginate($perPage);
        }

        return view('pages.admin.instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('pages.admin.instansi.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255|unique:instansi,nama',
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'background' => 'required|string|max:255'
            ]);

            $profilePath = $request->file('profile')->store('profiles', 'public');

            Instansi::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'profile' => $profilePath,
                'background' => $request->background
            ]);

            return redirect()->route('dashboard.instansi.index');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function edit($id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('pages.admin.instansi.edit', compact('instansi'));
    }


    public function update(Request $request, $id)
    {
        try {
            $instansi = Instansi::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:instansi,nama,' . $id . ',id_instansi',
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'background' => 'required|string|max:255'
            ]);

            if ($request->hasFile('profile')) {
                if ($instansi->profile) {
                    Storage::disk('public')->delete($instansi->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = $instansi->profile;
            }

            $updated = $instansi->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'deskripsi' => $request->deskripsi,
                'profile' => $profilePath,
                'background' => $request->background
            ]);

            if (!$updated) {
                return back()->with('error', 'Gagal memperbarui Instansi.');
            }

            return redirect()->route('dashboard.instansi.index')->with('success', 'Instansi berhasil diperbarui');
        } catch (\Exception $e) {
            // Log::error('Update User Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $instansi = Instansi::find($id);

        $instansi->delete();

        Alert::success('Success', 'Instansi berhasil dihapus');

        return redirect()->route('dashboard.instansi.index');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $instansi = Instansi::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.instansi.index', compact('instansi'));
    }
}
