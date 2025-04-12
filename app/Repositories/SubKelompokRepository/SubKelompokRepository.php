<?php

namespace App\Repositories\SubKelompokRepository;

use App\Models\SubKelompok;
use App\Repositories\BaseRepository;
use App\Repositories\SubKelompokRepository\SubKelompokRepositoryInterface;

class SubKelompokRepository extends BaseRepository implements SubKelompokRepositoryInterface
{
    public function __construct(SubKelompok $SubKelompok)
    {
        parent::__construct($SubKelompok);
    }

    public function all()
    {
        return $this->model->with('kelompok')->get();
    }

    public function find($id)
    {
        return $this->model->with('kelompok')->findOrFail($id);
    }

    public function search($keyword)
    {
        return $this->model->with('kelompok')->when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', "%$keyword%");
        })->orderBy('created_at', 'ASC');
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $SubKelompok = $this->model->findOrFail($id);
        return $SubKelompok->update($data);
    }
}
