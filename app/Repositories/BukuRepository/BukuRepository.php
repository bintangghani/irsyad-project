<?php

namespace App\Repositories\BukuRepository;

use App\Models\Buku;
use App\Repositories\BaseRepository;
use App\Repositories\BukuRepository\BukuRepositoryInterface;

class BukuRepository extends BaseRepository implements BukuRepositoryInterface
{
    public function __construct(Buku $buku)
    {
        parent::__construct($buku);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $buku = $this->model->findOrFail($id);
        $buku->update($data);
        return $buku;
    }

    public function search($keyword)
    {
        $model = $this->model
            ->where('judul', 'like', "%$keyword%")
            ->get();

        return $model ?: null;
    }

    public function findByTitle($title)
    {
        $buku = $this->model->where('judul', $title)->first();

        return $buku ?: null;
    }

    public function getBukuWithRelations($keyword = null, $perPage = 10)
    {
        $query = $this->model
            ->with(['uploaded:id_user,nama', 'jenis:id_jenis,nama', 'sub_kelompok:id_sub_kelompok,nama'])
            ->select(['id_buku', 'judul', 'tahun_terbit', 'uploaded_by', 'jenis', 'sub_kelompok', 'created_at']);

        if (!empty($keyword)) {
            $query->where('judul', 'like', "%$keyword%");
        }

        return $query->orderBy('created_at', 'ASC')->paginate($perPage);
    }

    public function getSingleBukuWithRelations($id)
    {
        return $this->model
            ->with(['uploaded:id_user,nama', 'jenis:id_jenis,nama', 'sub_kelompok:id_sub_kelompok,nama'])
            ->find($id);
    }

    public function incrementReadCount($id)
    {
        return $this->model->where('id_buku', $id)->increment('total_read');
    }

    public function incrementDownloadCount($id)
    {
        return $this->model->where('id_buku', $id)->increment('total_download');
    }
}
