<?php

namespace App\Repositories\KelompokRepository;

use App\Models\Kelompok;
use App\Repositories\BaseRepository;
use App\Repositories\KelompokRepository\KelompokRepositoryInterface;

class KelompokRepository extends BaseRepository implements KelompokRepositoryInterface
{
    public function __construct(Kelompok $Kelompok)
    {
        parent::__construct($Kelompok);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $Kelompok = $this->model->findOrFail($id);
        return $Kelompok->update($data);
    }

    public function search($keyword)
    {
        return $this->model->when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', "%$keyword%");
        })->orderBy('created_at', 'ASC');
    }
}
