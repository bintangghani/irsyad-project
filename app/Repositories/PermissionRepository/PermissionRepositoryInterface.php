<?php

namespace App\Repositories\PermissionRepository;

use Illuminate\Http\Request;

interface PermissionRepositoryInterface
{
    public function all();

    public function find($id);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function search($keyword);
}
