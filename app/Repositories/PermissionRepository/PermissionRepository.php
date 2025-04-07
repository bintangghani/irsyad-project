<?php

namespace App\Repositories\PermissionRepository;

use App\Models\Permission;
use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\PermissionRepository\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
    }

    public function search($keyword)
    {
        $model = $this->model->where('nama', 'like', "%$keyword%")->get();

        return $model ? $model : null;
    }
}
