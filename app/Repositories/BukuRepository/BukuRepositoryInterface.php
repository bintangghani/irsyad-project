<?php

namespace App\Repositories\BukuRepository;

interface BukuRepositoryInterface
{
    public function all();

    public function find($id);

    public function findById($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function search($keyword);

    public function findByTitle($title);

    public function getBukuWithRelations($keyword = null, $perPage = 10);

    public function getSingleBukuWithRelations($id);

    public function incrementReadCount($id);

    public function incrementDownloadCount($id);
}
