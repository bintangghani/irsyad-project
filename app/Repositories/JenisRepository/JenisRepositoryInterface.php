<?php

namespace App\Repositories\JenisRepository;

interface JenisRepositoryInterface
{
    public function all();

    public function find($id);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function search($keyword);
}
