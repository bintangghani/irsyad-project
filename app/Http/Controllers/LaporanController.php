<?php

namespace App\Http\Controllers;

use App\Exports\BukuExport;
use App\Models\Buku;
use App\Models\SubKelompok;
use App\Models\Instansi;
use App\Models\Jenis;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (!haveAccessTo('view_buku')) {
            return redirect()->back();
        }

        $query = Buku::with(['uploaded.instansi', 'subKelompok.kelompok', 'jenisBuku']);

        // Filter by Tahun Terbit
        if ($request->filled('tahun_terbit')) {
            $query->where('tahun_terbit', $request->tahun_terbit);
        }

        // Filter by Jenis (id_jenis)
        if ($request->filled('jenis')) {
            if (is_array($request->jenis)) {
                $query->whereIn('jenis', $request->jenis);
            } else {
                $query->where('jenis', $request->jenis);
            }
        }


        // Filter by Sub Kelompok (id_sub_kelompok)
        if ($request->filled('sub_kelompok')) {
            if (is_array($request->sub_kelompok)) {
                $query->whereIn('sub_kelompok', $request->sub_kelompok);
            } else {
                $query->where('sub_kelompok', $request->sub_kelompok);
            }
        }

        // Filter by Kelompok via SubKelompok relationship
        if ($request->filled('id_kelompok')) {
            if (is_array($request->id_kelompok)) {
                $query->whereHas('subKelompok.kelompok', function ($q) use ($request) {
                    $q->whereIn('id_kelompok', $request->id_kelompok);
                });
            } else {
                $query->whereHas('subKelompok.kelompok', function ($q) use ($request) {
                    $q->where('id_kelompok', $request->id_kelompok);
                });
            }
        }

        // Filter by Instansi via uploaded.instansi relationship
        if ($request->filled('id_instansi')) {
            if (is_array($request->id_instansi)) {
                $query->whereHas('uploaded.instansi', function ($q) use ($request) {
                    $q->whereIn('id_instansi', $request->id_instansi);
                });
            } else {
                $query->whereHas('uploaded.instansi', function ($q) use ($request) {
                    $q->where('id_instansi', $request->id_instansi);
                });
            }
        }

        // Filter by total_read range
        if ($request->filled('min_total_read')) {
            $query->where('total_read', '>=', $request->min_total_read);
        }

        if ($request->filled('max_total_read')) {
            $query->where('total_read', '<=', $request->max_total_read);
        }

        $buku = $query->get();

        $subKelompoks = SubKelompok::all();
        $kelompoks = Kelompok::all();
        $instansis = Instansi::all();
        $jenisBuku = Jenis::all();

        return view('pages.admin.laporan.index', compact('buku', 'subKelompoks', 'kelompoks', 'instansis', 'jenisBuku'));
    }

    public function export(Request $request)
    {
        if (!haveAccessTo('view_buku')) {
            return redirect()->back();
        }

        // Kita teruskan semua filter dari request ke export class
        return Excel::download(new BukuExport($request->all()), 'laporan_buku.xlsx');
    }
}
