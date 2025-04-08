<?php

namespace App\Repositories\UserRepository;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function all();

    public function find($id);

    public function findById($id);

    public function create(array $data);

    public function store(array $data, string $profilePath);

    public function update($id, array $data);

    public function delete($id);

    public function search($keyword);

    public function findOneByEmail(string $email);
    public function findOneByEmailAndName(string $email, string $name);
    public function getUsersWithRole(?string $keyword, int $perPage);
    public function findByIdWithRoleAndInstansi(string $id);
    public function updateAll(array $data, string $profilePath, array $user);
}
