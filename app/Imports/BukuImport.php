<?php

namespace App\Imports;

use App\Models\Jenis;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Repositories\BukuRepository\BukuRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\SubKelompok;
use App\Models\Kelompok;

class BukuImport implements ToCollection, WithHeadingRow
{
    protected BukuRepositoryInterface $bukuRepository;

    protected array $fieldMap = [
        'judul'              => 'judul_buku',
        'no_isbn'            => 'isbn',
        'penulis'            => 'penulis',
        'penerbit'           => 'penerbit',
        'alamat_penerbit'    => 'alamat_penerbit',
        'tahun_terbit'       => 'tahun_terbit',
        'jumlah_halaman'     => 'jumlah',
        'sampul'             => 'sampul',
        'deskripsi'          => 'deskripsi',
        'file_buku'          => 'file_buku',
        'sub_kelompok'       => 'sub_kategori',
        'kelompok'           => 'kategori',
        'jenis'              => 'jenis',
    ];

    public function __construct(BukuRepositoryInterface $bukuRepository)
    {
        $this->bukuRepository = $bukuRepository;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $data = $row->toArray();

            if ($index === 0) {
                Log::debug("Kolom dari Excel:", $data);
            }

            $dataLower = array_change_key_case($data, CASE_LOWER);
            $fieldMapLower = array_change_key_case($this->fieldMap, CASE_LOWER);

            $mappedData = [];
            foreach ($fieldMapLower as $dbField => $excelField) {
                $mappedData[$dbField] = $dataLower[strtolower($excelField)] ?? null;
            }

            $validator = Validator::make($mappedData, [
                'judul'           => ['required', 'string', 'max:255', Rule::unique('buku', 'judul')],
                'no_isbn'         => 'nullable|string|max:20|regex:/^[0-9\-]+$/',
                'penulis'         => 'nullable|string|max:255',
                'penerbit'        => 'nullable|string|max:255',
                'alamat_penerbit' => 'nullable|string|max:500',
                'tahun_terbit'    => 'nullable|digits:4|integer',
                'jumlah_halaman'  => 'nullable|integer|min:1',
                'sampul'          => 'nullable|string',
                'deskripsi'       => 'nullable|string',
                'file_buku'       => 'nullable|string',
                'sub_kelompok'    => 'nullable|string',
                'kelompok'        => 'nullable|string',
                'jenis'           => 'nullable|string',
            ]);

            if ($validator->fails()) {
                Log::warning("Baris ke-" . ($index + 1) . " gagal validasi.", [
                    'errors' => $validator->errors()->all(),
                    'data'   => $mappedData,
                ]);
                continue;
            }

            $jenis = $mappedData['jenis']
                ? Jenis::firstOrCreate(['nama' => $mappedData['jenis']])
                : null;

            // Buat atau ambil kelompok (kategori)
            $kelompok = $mappedData['kelompok']
                ? Kelompok::firstOrCreate(['nama' => $mappedData['kelompok']])
                : null;

            // Buat atau ambil sub_kelompok (sub_kategori)
            $subKelompok = $mappedData['sub_kelompok']
                ? SubKelompok::firstOrCreate(
                    ['nama' => $mappedData['sub_kelompok']],
                    ['id_kelompok' => $kelompok?->id_kelompok]
                )
                : null;

            // Validasi file (jika ada)
            $sampulPath = $mappedData['sampul'] ? "sampuls/" . $mappedData['sampul'] : null;
            $fileBukuPath = $mappedData['file_buku'] ? "buku/" . $mappedData['file_buku'] : null;

            if ($sampulPath && !file_exists(storage_path('app/public/' . $sampulPath))) {
                Log::warning("Baris ke-" . ($index + 1) . " dilewati: file sampul tidak ditemukan.", ['sampul' => $sampulPath]);
                continue;
            }

            if ($fileBukuPath && !file_exists(storage_path('app/public/' . $fileBukuPath))) {
                Log::warning("Baris ke-" . ($index + 1) . " dilewati: file buku tidak ditemukan.", ['file_buku' => $fileBukuPath]);
                continue;
            }

            // Simpan buku
            $this->bukuRepository->create([
                'judul'           => $mappedData['judul'],
                'no_isbn'         => $mappedData['no_isbn'],
                'penulis'         => $mappedData['penulis'],
                'penerbit'        => $mappedData['penerbit'],
                'alamat_penerbit' => $mappedData['alamat_penerbit'],
                'tahun_terbit'    => $mappedData['tahun_terbit'],
                'jumlah_halaman'  => $mappedData['jumlah_halaman'],
                'sampul'          => $sampulPath,
                'deskripsi'       => $mappedData['deskripsi'],
                'file_buku'       => $fileBukuPath,
                'total_download'  => 0,
                'total_read'      => 0,
                'uploaded_by'     => Auth::id(),
                'sub_kelompok'    => $subKelompok?->id_sub_kelompok,
                'jenis'           => $jenis?->id_jenis,
            ]);
        }
    }
}
