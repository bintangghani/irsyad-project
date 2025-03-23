<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'role_permission';
    protected $primaryKey = 'id_role_permission';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'id_permission', 'id_permission');
    }
}
