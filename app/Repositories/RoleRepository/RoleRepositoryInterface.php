<?php

namespace App\Repositories\RoleRepository;

use Illuminate\Http\Request;

interface RoleRepositoryInterface
{
    public function all();

    public function find($id);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function search($keyword);

    public function getRolesWithPermissions(?string $keyword, int $perPage);
    public function getRoleWithPermissions($id);
    public function updateRoleWithPermissions($id, array $data, array $permissions);
    public function syncPermissions(Role $role, array $permission);
}
