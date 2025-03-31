<?php

namespace App\Repositories\RoleRepository;

use App\Models\Role;
use App\Repositories\BaseRepository;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\RoleRepository\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(Role $role)
    {
        parent::__construct($role);
    }

    public function search($keyword)
    {
        $model = $this->model->where('nama', 'like', "%$keyword%")->get();

        return $model ? $model : null;
    }

    public function getRolesWithPermissions($keyword, $perPage)
    {
        $query = $this->model->with(['permissions:id_permission,nama'])->select(['id_role', 'nama']);

        if (!empty($keyword)) {
            $query->where('nama', 'LIKE', "%$keyword%");
        }

        return $query->orderBy('created_at', 'ASC')->paginate($perPage);
    }

    public function getRoleWithPermissions($id)
    {
        $query = $this->model->with(['permissions:id_permission,nama'])->find($id, ['id_role', 'nama']);

        return $query;
    }

    public function syncPermissions($role, $permissions)
    {
        DB::transaction(function () use ($role, $permissions) {
            foreach ($permissions as $permissionId) {
                $role->permissions()->attach($permissionId, [
                    'id_role_permission' => Uuid::uuid4()->toString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }

    public function updateRoleWithPermissions($id, $data, $permissions)
    {
        return DB::transaction(function () use ($id, $data, $permissions) {
            $role = $this->model->findOrFail($id);

            $role->update(['nama' => $data['nama']]);

            $role->permissions()->sync(
                collect($permissions)->mapWithKeys(function ($permissionId) {
                    return [
                        $permissionId => [
                            'id_role_permission' => Uuid::uuid4(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    ];
                })
            );

            return $role;
        });
    }
}
