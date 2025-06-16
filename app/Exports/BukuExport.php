<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BukuExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;
    private $counter = 0;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $filters = $this->filters; // untuk closure use

        $query = Buku::with(['uploaded.instansi', 'subKelompok.kelompok', 'jenisBuku']);

        if (!empty($filters['tahun_terbit'])) {
            $query->where('tahun_terbit', $filters['tahun_terbit']);
        }

        if (!empty($filters['jenis'])) {
            if (is_array($filters['jenis'])) {
                $query->whereIn('jenis', $filters['jenis']);
            } else {
                $query->where('jenis', $filters['jenis']);
            }
        }

        if (!empty($filters['sub_kelompok'])) {
            if (is_array($filters['sub_kelompok'])) {
                $query->whereIn('sub_kelompok', $filters['sub_kelompok']);
            } else {
                $query->where('sub_kelompok', $filters['sub_kelompok']);
            }
        }

        if (!empty($filters['id_kelompok'])) {
            if (is_array($filters['id_kelompok'])) {
                $query->whereHas('subKelompok.kelompok', function ($q) use ($filters) {
                    $q->whereIn('id_kelompok', $filters['id_kelompok']);
                });
            } else {
                $query->whereHas('subKelompok.kelompok', function ($q) use ($filters) {
                    $q->where('id_kelompok', $filters['id_kelompok']);
                });
            }
        }

        if (!empty($filters['id_instansi'])) {
            if (is_array($filters['id_instansi'])) {
                $query->whereHas('uploaded.instansi', function ($q) use ($filters) {
                    $q->whereIn('id_instansi', $filters['id_instansi']);
                });
            } else {
                $query->whereHas('uploaded.instansi', function ($q) use ($filters) {
                    $q->where('id_instansi', $filters['id_instansi']);
                });
            }
        }

        // Filter range total_read jika ada
        if (!empty($filters['min_total_read'])) {
            $query->where('total_read', '>=', $filters['min_total_read']);
        }

        if (!empty($filters['max_total_read'])) {
            $query->where('total_read', '<=', $filters['max_total_read']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Buku',
            'Tahun Terbit',
            'Jenis',
            'Sub Kelompok',
            'Kelompok',
            'Instansi',
            'Total Read',
        ];
    }

    public function map($buku): array
    {
        $this->counter++;

        return [
            $this->counter,
            $buku->judul ?? '-',
            $buku->tahun_terbit ?? '-',
            $buku->jenisBuku->nama ?? '-',
            $buku->subKelompok->nama ?? '-',
            $buku->subKelompok->kelompok->nama ?? '-',
            $buku->uploaded->instansi->nama ?? '-',
            $buku->total_read ?? 0,
        ];
    }
}
