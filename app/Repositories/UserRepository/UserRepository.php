<?php

namespace App\Repositories\UserRepository;

use App\Models\User;
use App\Repositories\BaseRepository;
use Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\UserRepository\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function store($data, $profilePath) 
    {
        $this->model->create([
            ...$data,
            'password' => Hash::make($data['password']),
            'profile' => $profilePath
        ]);

        return;
    }

    public function search($keyword)
    {
        $model = $this->model->where('nama', 'like', "%$keyword%")->get();

        return $model ? $model : null;
    }

    public function findOneByEmail(string $email)
    {
        $model = $this->model->where('email', $email)->first();
        
        return $model ? $model : null;
    }

    public function findOneByEmailAndName(string $email, string $name)
    {
        $model = $this->model->where('email', $email)->where('name', $name)->first();

        return $model ? $model : null;
    }

    public function getUsersWithRole($keyword, $perPage)
    {
        $query = $this->model->with(['role:id_role,nama', 'instansi:id_instansi,nama'])->select(['id_user', 'nama', 'email', 'moto', 'profile', 'id_role', 'id_instansi']);

        if (!empty($keyword)) {
            $query->where('nama', 'LIKE', "%$keyword%");
        }

        return $query->orderBy('created_at', 'ASC')->paginate($perPage) ?? null;
    }

    public function findByIdWithRoleAndInstansi($id)
    {
        $model = $this->model->with(['role:id_role,nama', 'instansi:id_instansi,nama'])->findOrFail($id);

        return $model ? $model : null;
    }

    public function updateAll($data, $profilePath, $user)
    {
        $model = $user->update([
            ...$data,
            'profile' => $profilePath,
            'password' => $data['password'] ? Hash::make($data['password']) : $user['password']
        ]);

        return $model ? $model : null;
    }
}
