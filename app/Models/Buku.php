<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function uploaded()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id_user');
    }

    public function subKelompok()
    {
        return $this->belongsTo(SubKelompok::class, 'sub_kelompok', 'id_sub_kelompok');
    }

    public function jenisBuku()
    {
        return $this->belongsTo(Jenis::class, 'jenis', 'id_jenis');
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class, 'id_buku', 'id_buku');
    }
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok', 'id_kelompok');
    }
}
