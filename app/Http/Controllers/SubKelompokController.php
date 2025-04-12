<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubKelompokRequest;
use App\Repositories\SubKelompokRepository\SubKelompokRepositoryInterface;
use App\Repositories\KelompokRepository\KelompokRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class SubKelompokController extends Controller
{
    public function __construct(
        protected SubKelompokRepositoryInterface $subKelompokRepository,
        protected KelompokRepositoryInterface $kelompokRepository
    ) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $subkelompok = $this->subKelompokRepository->search($search)->paginate($perPage);

        return view('pages.admin.subkelompok.index', compact('subkelompok'));
    }

    public function create()
    {
        if (!haveAccessTo('create_subkelompok')) {
            return redirect()->back();
        }
        $subkelompok = $this->subKelompokRepository->all();
        $kelompok = $this->kelompokRepository->all();
        return view('pages.admin.subkelompok.create', compact('subkelompok', 'kelompok'));
    }

    public function store(SubKelompokRequest $request)
    {
        if (!haveAccessTo('create_subkelompok')) {
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->subKelompokRepository->create($validated);

            DB::commit();
            Alert::success('Success', 'Subkelompok berhasil ditambah');

            return redirect()->route('dashboard.buku.subkelompok.index')
                ->with('success', 'SubKelompok berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error storing subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        if (!haveAccessTo('update_subkelompok')) {
            return redirect()->back();
        }
        $subkelompok = $this->subKelompokRepository->find($id);
        $kelompok = $this->kelompokRepository->all();
        return view('pages.admin.subkelompok.edit', compact('kelompok', 'subkelompok'));
    }

    public function update(SubKelompokRequest $request, $id)
    {
        if (!haveAccessTo('update_subkelompok')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $validated = $request->validated();

            $updated = $this->subKelompokRepository->update($id, $validated);

            if (!$updated) {
                DB::rollBack();
                return back()->with('error', 'Gagal memperbarui subkelompok.');
            }

            DB::commit();
            Alert::success('Success', 'Subkelompok berhasil diperbarui');

            return redirect()->route('dashboard.buku.subkelompok.index')
                ->with('success', 'Sub Kelompok berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error updating subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        if (!haveAccessTo('delete_subkelompok')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $this->subKelompokRepository->delete($id);

            DB::commit();
            Alert::success('Success', 'Subkelompok berhasil dihapus');
            return redirect()->route('dashboard.buku.subkelompok.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error deleting subkelompok: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus subkelompok.');
        }
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_subkelompok')) {
            return redirect()->back();
        }
        $keyword = $request->search;
        $subkelompok = $this->subKelompokRepository->search($keyword)->paginate(10);

        return view('pages.admin.subkelompok.index', compact('subkelompok'));
    }
}
