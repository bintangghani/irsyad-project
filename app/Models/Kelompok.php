<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelompok extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'kelompok';
    protected $primaryKey = 'id_kelompok';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function sub_kelompok()
    {
        return $this->hasMany(SubKelompok::class, 'id_kelompok', 'id_kelompok');
    }

    public function buku()
    {
        return $this->hasManyThrough(Buku::class, SubKelompok::class, 'id_kelompok', 'sub_kelompok', 'id_kelompok', 'id_sub_kelompok');
    }
}
