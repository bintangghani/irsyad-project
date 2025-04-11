<?php

namespace App\Repositories\InstansiRepository;

use App\Models\Instansi;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;

class InstansiRepository extends BaseRepository implements InstansiRepositoryInterface
{
    public function __construct(Instansi $model)
    {
        parent::__construct($model);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $instansi = $this->findById($id);
        $instansi->update($data);
        return $instansi;
    }

    // public function delete($id)
    // {
    //     $instansi = $this->findById($id);
    //     return $instansi->delete();
    // }

    public function search(string $keyword)
    {
        return $this->model
            ->where('nama', 'like', "%$keyword%")
            ->orWhere('alamat', 'like', "%$keyword%")
            ->orWhere('deskripsi', 'like', "%$keyword%")
            ->get();
    }

    public function searchAndPaginate(?string $keyword, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%$keyword%")
                    ->orWhere('alamat', 'like', "%$keyword%")
                    ->orWhere('deskripsi', 'like', "%$keyword%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
