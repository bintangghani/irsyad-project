<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'id_role',
            'id_permission',
            'id_role',
            'id_permission'
        );
    }

    public function user()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
