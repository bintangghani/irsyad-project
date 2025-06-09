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
            $profilePath = $instansi->profile;
            if ($request->hasFile('profile')) {
                Storage::disk('public')->delete($profilePath);
                $profilePath = $request->file('profile')->store('profiles', 'public');
            }
            $backgroundPath = $instansi->background;
            if ($request->hasFile('background')) {
                Storage::disk('public')->delete($backgroundPath);
                $backgroundPath = $request->file('background')->store('backgrounds', 'public');
            }
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
            return redirect()->route('dashboard.user.instansi.index');
        } catch (\Throwable $th) {
            Log::error('Import error: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data.');
        }
    }

    public function profileInstansi($id)
    {
        if (!haveAccessTo('view_profile_instansi')) {
            return redirect()->back();
        }
        $instansi = $this->instansiRepository->findById($id);
        return view('pages.admin.profileinstansi.index', compact('instansi'));
    }

    public function editProfile($id)
    {
        $instansi = Instansi::findOrFail($id);
        return view('pages.admin.profileinstansi.index', compact('instansi'));
    }

    public function updateProfile(Request $request, $id)
    {
        try {
            $instansi = Instansi::findOrFail($id);
            $request->validate([
                'nama' => 'nullable|string|max:255',
                'alamat' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string|max:255',
                'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'background' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
            if ($request->hasFile('profile')) {
                if ($instansi->profile) {
                    Storage::disk('public')->delete($instansi->profile);
                }
                $profilePath = $request->file('profile')->store('profiles', 'public');
                $instansi->profile = $profilePath;
            }
            if ($request->hasFile('background')) {
                if ($instansi->background) {
                    Storage::disk('public')->delete($instansi->background);
                }
                $backgroundPath = $request->file('background')->store('backgrounds', 'public');
                $instansi->background = $backgroundPath;
            }
            if ($request->filled('nama')) {
                $instansi->nama = $request->nama;
            }
            if ($request->filled('alamat')) {
                $instansi->alamat = $request->alamat;
            }
            if ($request->filled('deskripsi')) {
                $instansi->deskripsi = $request->deskripsi;
            }
            $instansi->save();
            return redirect()->back()->with('success', 'Profile instansi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui profile: ' . $e->getMessage()
            ]);
        }
    }
}
