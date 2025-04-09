<?php

namespace App\Http\Controllers;

use App\Http\Requests\JenisRequest;
use App\Models\Jenis;
use App\Repositories\JenisRepository\JenisRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class JenisController extends Controller
{
    public function __construct(
        protected JenisRepositoryInterface $jenisRepository,
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $jenis = $this->jenisRepository->search($search)->paginate($perPage);

        return view('pages.admin.jenis.index', compact('jenis'));
    }

    public function create()
    {
        if (!haveAccessTo('create_jenis')) {
            return redirect()->back();
        }
        return view('pages.admin.jenis.create');
    }

    public function store(JenisRequest $request)
    {
        if (!haveAccessTo('create_jenis')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->jenisRepository->create($validated);

            DB::commit();

            Alert::success('Success', 'Jenis berhasil ditambahkan');

            return redirect()->route('dashboard.buku.jenis.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error storing Jenis: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    public function edit($id)
    {
        if (!haveAccessTo('update_jenis')) {
            return redirect()->back();
        }
        $jenis = $this->jenisRepository->find($id);
        return view('pages.admin.jenis.edit', compact('jenis'));
    }

    public function update(JenisRequest $request, $id)
    {
        if (!haveAccessTo('update_jenis')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            $this->jenisRepository->update($id, $validated);

            DB::commit();

            Alert::success('Success', 'Jenis berhasil diperbarui');

            return redirect()->route('dashboard.buku.jenis.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error updating Jenis: ' . $th->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function destroy($id)
    {
        if (!haveAccessTo('delete_jenis')) {
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

            $this->jenisRepository->delete($id);

            DB::commit();

            Alert::success('Success', 'Jenis berhasil dihapus');

            return redirect()->route('dashboard.buku.jenis.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error deleting jenis: ' . $th->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus jenis.');
        }
    }

    public function search(Request $request)
    {
        if (!haveAccessTo('view_jenis')) {
            return redirect()->back();
        }
        $keyword = $request->search;
        $jenis = $this->jenisRepository->search($keyword);

        return view('pages.admin.jenis.index', compact('jenis'));
    }
}
