<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
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
            // Validasi input dengan pesan error yang jelas
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:instansi,nama',
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'profile' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                'background' => 'required|string|max:255'
            ], [
                'nama.required' => 'Nama instansi wajib diisi!',
                'nama.string' => 'Nama instansi harus berupa teks!',
                'nama.max' => 'Nama instansi maksimal 255 karakter!',
                'nama.unique' => 'Nama instansi sudah terdaftar, gunakan nama lain!',

                'alamat.required' => 'Alamat instansi wajib diisi!',
                'alamat.string' => 'Alamat harus berupa teks!',
                'alamat.max' => 'Alamat maksimal 255 karakter!',

                'deskripsi.required' => 'Deskripsi instansi wajib diisi!',
                'deskripsi.string' => 'Deskripsi harus berupa teks!',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter!',

                'profile.required' => 'Foto profil wajib diunggah!',
                'profile.image' => 'File harus berupa gambar!',
                'profile.mimes' => 'Format yang diperbolehkan hanya JPG, JPEG, PNG!',
                'profile.max' => 'Ukuran maksimal gambar adalah 2MB!',

                'background.required' => 'Background wajib diisi!',
                'background.string' => 'Background harus berupa teks!',
                'background.max' => 'Background maksimal 255 karakter!',
            ]);

            $profilePath = $request->file('profile')->store('profiles', 'public');

            Instansi::create([
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'deskripsi' => $validated['deskripsi'],
                'profile' => $profilePath,
                'background' => $validated['background']
            ]);

            Alert::success('Success', 'Instansi berhasil ditambah');

            return redirect()->route('dashboard.instansi.index')
                ->with('success', 'Instansi berhasil ditambahkan.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Error storing instansi: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
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
                'nama' => 'required|string|max:255|unique:instansi,nama,' . $id,
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
                'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'background' => 'required|string|max:255'
            ], [
                'nama.required' => 'Nama instansi wajib diisi!',
                'nama.string' => 'Nama instansi harus berupa teks!',
                'nama.max' => 'Nama instansi maksimal 255 karakter!',
                'nama.unique' => 'Nama instansi sudah terdaftar, gunakan nama lain!',

                'alamat.required' => 'Alamat instansi wajib diisi!',
                'alamat.string' => 'Alamat harus berupa teks!',
                'alamat.max' => 'Alamat maksimal 255 karakter!',

                'deskripsi.required' => 'Deskripsi instansi wajib diisi!',
                'deskripsi.string' => 'Deskripsi harus berupa teks!',
                'deskripsi.max' => 'Deskripsi maksimal 255 karakter!',

                'profile.image' => 'File harus berupa gambar!',
                'profile.mimes' => 'Format yang diperbolehkan hanya JPG, JPEG, PNG!',
                'profile.max' => 'Ukuran maksimal gambar adalah 2MB!',

                'background.required' => 'Background wajib diisi!',
                'background.string' => 'Background harus berupa teks!',
                'background.max' => 'Background maksimal 255 karakter!',
            ]);

            if ($request->hasFile('profile')) {
                if ($instansi->profile) {
                    Storage::disk('public')->delete($instansi->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
            } else {
                $profilePath = $instansi->profile;
            }

            $instansi->update([
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'deskripsi' => $validated['deskripsi'],
                'profile' => $profilePath,
                'background' => $validated['background']
            ]);

            Alert::success('Success', 'Instansi berhasil diperbarui');

            return redirect()->route('dashboard.instansi.index')->with('success', 'Instansi berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            Log::error('Error updating instansi: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
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

            return redirect()->route('dashboard.instansi.index')->with('success', 'User berhasil dihapus');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $instansi = Instansi::where('nama', 'like', "%$keyword%")->get();

        return view('pages.admin.instansi.index', compact('instansi'));
    }
}
