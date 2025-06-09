<?php

namespace App\Imports;

use App\Helpers\FileNameHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Repositories\BukuRepository\BukuRepositoryInterface;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\SubKelompok;
use App\Models\Jenis;

class BukuImport implements ToCollection, WithHeadingRow
{
    protected BukuRepositoryInterface $bukuRepository;

    public function __construct(BukuRepositoryInterface $bukuRepository)
    {
        $this->bukuRepository = $bukuRepository;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = $row->toArray();

            $subKelompok = SubKelompok::where('nama', $data['sub_kelompok'])->first();
            $jenis = Jenis::where('nama', $data['jenis'])->first();

            if (!$subKelompok || !$jenis) {
                continue;
            }

            $validator = Validator::make($data, [
                'judul' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('buku', 'judul')
                ],
                'penerbit' => 'required|string|max:255',
                'alamat_penerbit' => 'required|string|max:500',
                'tahun_terbit' => 'required|digits:4|integer',
                'jumlah_halaman' => 'required|integer|min:1',
                'sampul' => 'required|string',
                'deskripsi' => 'required|string',
                'file_buku' => 'required|string',
                'sub_kelompok' => 'required|string',
                'jenis' => 'required|string',
            ]);

            $sampulPath = "sampuls/" . $data['sampul'];
            $fileBukuPath = "buku/" . $data['file_buku'];

            $this->bukuRepository->create([
                'judul' => $data['judul'],
                'penerbit' => $data['penerbit'],
                'alamat_penerbit' => $data['alamat_penerbit'],
                'tahun_terbit' => $data['tahun_terbit'],
                'jumlah_halaman' => $data['jumlah_halaman'],
                'sampul' => $sampulPath,
                'deskripsi' => $data['deskripsi'],
                'file_buku' => $fileBukuPath,
                'total_download' => 0,
                'total_read' => 0,
                'uploaded_by' => Auth::id(),
                'sub_kelompok' => $subKelompok->id_sub_kelompok,
                'jenis' => $jenis->id_jenis,
            ]);
        }
    }
}
