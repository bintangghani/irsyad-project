<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstansiRequest;
use App\Imports\InstansiImport;
use Illuminate\Http\Request;
use App\Models\Instansi;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class InstansiController extends Controller
{
    public function __construct(
        protected InstansiRepositoryInterface $instansiRepository
    ) {}

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
        if (!haveAccessTo('create_instansi')) {
            return redirect()->back();
        }
        return view('pages.admin.instansi.create');
    }

    public function store(InstansiRequest $request)
    {
        if (!haveAccessTo('create_instansi')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $profilePath = $request->file('profile')->store('profiles', 'public');
            $backgroundPath = $request->file('background')->store('backgrounds', 'public');

            $data = $request->validated();
            $data['profile'] = $profilePath;
            $data['background'] = $backgroundPath;

            $this->instansiRepository->create($data);

            DB::commit();
            Alert::success('Success', 'Instansi berhasil ditambah');
            return redirect()->route('dashboard.user.instansi.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error storing instansi: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function edit($id)
    {
        if (!haveAccessTo('update_instansi')) {
            return redirect()->back();
        }
        $instansi = $this->instansiRepository->findById($id);
        return view('pages.admin.instansi.edit', compact('instansi'));
    }


    public function update(InstansiRequest $request, $id)
    {
        if (!haveAccessTo('update_instansi')) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $instansi = $this->instansiRepository->findById($id);

            // Simpan profile lama, jika ada file baru, hapus lama & ganti
            $profilePath = $instansi->profile;
            if ($request->hasFile('profile')) {
                Storage::disk('public')->delete($profilePath);
                $profilePath = $request->file('profile')->store('profiles', 'public');
            }

            // Simpan background lama, jika ada file baru, hapus lama & ganti
            $backgroundPath = $instansi->background;
            if ($request->hasFile('background')) {
                Storage::disk('public')->delete($backgroundPath);
                $backgroundPath = $request->file('background')->store('backgrounds', 'public');
            }

            // Ambil data yang sudah tervalidasi
            $data = $request->validated();
            $data['profile'] = $profilePath;
            $data['background'] = $backgroundPath;

            $this->instansiRepository->update($id, $data);

            DB::commit();
            Alert::success('Success', 'Instansi berhasil diperbarui');
            return redirect()->route('dashboard.user.instansi.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error updating instansi: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }


    public function destroy($id)
    {
        if (!haveAccessTo('delete_instansi')) {
            return redirect()->back();
        }
        $this->instansiRepository->delete($id);

        Alert::success('Success', 'Instansi berhasil dihapus');
        return redirect()->route('dashboard.user.instansi.index');
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_instansi')) {
            return redirect()->back();
        }
        $instansi = $this->instansiRepository->search($request->search);
        return view('pages.admin.instansi.index', compact('instansi'));
    }

    public function importForm()
    {
        return view('pages.admin.instansi.import');
    }

    public function import(Request $request)
    {
        if (!haveAccessTo('import_instansi')) {
            return redirect()->back();
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new InstansiImport($this->instansiRepository), $request->file('file'));
            Alert::success('Success', 'Data Instansi berhasil diimpor.');
            return redirect()->route('pages.admin.instansi.index');
        } catch (\Throwable $th) {
            Log::error('Import error: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data.');
        }
    }
}
