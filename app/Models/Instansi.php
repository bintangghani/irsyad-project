<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instansi extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'instansi';
    protected $primaryKey = 'id_instansi';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'id_instansi', 'id_instansi');
    }
}
