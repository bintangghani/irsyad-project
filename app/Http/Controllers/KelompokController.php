<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelompokRequest;
use App\Repositories\KelompokRepository\KelompokRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class KelompokController extends Controller
{
    public function __construct(
        protected KelompokRepositoryInterface $kelompokRepository,
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $kelompok = $this->kelompokRepository->search($search)->paginate($perPage);

        return view('pages.admin.kelompok.index', compact('kelompok'));
    }

    public function create()
    {
        if (!haveAccessTo('create_kelompok')) {
            return redirect()->back();
        }
        return view('pages.admin.kelompok.create');
    }

    public function store(KelompokRequest $request)
    {
        if (!haveAccessTo('create_kelompok')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->kelompokRepository->create($validated);

            DB::commit();

            Alert::success('Success', 'Kelompok berhasil ditambahkan');

            return redirect()->route('dashboard.buku.kelompok.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error storing kelompok: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function edit($id)
    {
        if (!haveAccessTo('update_kelompok')) {
            return redirect()->back();
        }
        $kelompok = $this->kelompokRepository->find($id);
        return view('pages.admin.kelompok.edit', compact('kelompok'));
    }

    public function update(KelompokRequest $request, $id)
    {
        if (!haveAccessTo('update_kelompok')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->kelompokRepository->update($id, $validated);

            DB::commit();

            Alert::success('Success', 'Kelompok berhasil diperbarui');

            return redirect()->route('dashboard.buku.kelompok.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error updating kelompok: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function destroy($id)
    {
        if (!haveAccessTo('delete_kelompok')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $this->kelompokRepository->delete($id);

            DB::commit();

            Alert::success('Success', 'Kelompok berhasil dihapus');

            return redirect()->route('dashboard.buku.kelompok.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error deleting kelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus kelompok.');
        }
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_kelompok')) {
            return redirect()->back();
        }
        $keyword = $request->search;
        $kelompok = $this->kelompokRepository->search($keyword)->paginate(10);

        return view('pages.admin.kelompok.index', compact('kelompok'));
    }
}