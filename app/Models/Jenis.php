<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jenis extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 

    protected $table = 'jenis';
    protected $primaryKey = 'id_jenis';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $dates = ['deleted_at'];
    protected $guarded = [];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'jenis', 'id_jenis');
    }
}
