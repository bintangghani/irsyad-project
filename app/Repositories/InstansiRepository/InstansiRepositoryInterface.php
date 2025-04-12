<?php

namespace App\Repositories\InstansiRepository;

use Illuminate\Pagination\LengthAwarePaginator;

interface InstansiRepositoryInterface
{
    public function all();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function search(string $keyword);
    public function searchAndPaginate(?string $keyword, int $perPage): LengthAwarePaginator;
}
