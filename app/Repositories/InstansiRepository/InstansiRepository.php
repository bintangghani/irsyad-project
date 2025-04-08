<?php

namespace App\Repositories\InstansiRepository;

use App\Models\Instansi;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\InstansiRepository\InstansiRepositoryInterface;
use Illuminate\Http\Request;

class InstansiRepository extends BaseRepository implements InstansiRepositoryInterface
{
    public function __construct(Instansi $instansi)
    {
        parent::__construct($instansi);
    }

    public function search($keyword)
    {
        $model = $this->model->where('nama', 'like', "%$keyword%")->get();

        return $model ? $model : null;
    }
}
