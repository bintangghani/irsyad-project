<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKelompok extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'sub_kelompok';
    protected $primaryKey = 'id_sub_kelompok';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok', 'id_kelompok');
    }

    public function buku()
    {
        return $this->hasMany(Buku::class, 'sub_kelompok', 'id_sub_kelompok');
    }
}
