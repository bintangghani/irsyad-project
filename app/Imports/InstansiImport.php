<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InstansiImport implements ToCollection, WithHeadingRow
{
    protected InstansiRepositoryInterface $instansiRepository;

    public function __construct(InstansiRepositoryInterface $instansiRepository)
    {
        $this->instansiRepository = $instansiRepository;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $validator = Validator::make($row->toArray(), [
                'nama' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('instansi', 'nama')
                ],
                'alamat' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                continue;
            }

            $this->instansiRepository->create([
                'nama'      => $row['nama'],
                'alamat'    => $row['alamat'],
                'deskripsi' => $row['deskripsi'],
                'profile'   => null,
                'background'=> null,
            ]);
        }
    }
}
