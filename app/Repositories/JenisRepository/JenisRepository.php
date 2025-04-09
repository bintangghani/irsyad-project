<?php

namespace App\Repositories\JenisRepository;

use App\Models\Jenis;
use App\Repositories\BaseRepository;
use App\Repositories\JenisRepository\JenisRepositoryInterface;

class JenisRepository extends BaseRepository implements JenisRepositoryInterface
{
    public function __construct(Jenis $jenis)
    {
        parent::__construct($jenis);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $jenis = $this->model->findOrFail($id);
        return $jenis->update($data);
    }

    // public function delete($id)
    // {
    //     $jenis = $this->model->findOrFail($id);
    //     return $jenis->delete();
    // }

    public function search($keyword)
    {
        return $this->model->when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', "%$keyword%");
        })->orderBy('created_at', 'ASC');
    }
}
