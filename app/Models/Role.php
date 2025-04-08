<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];


    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'id_role', 'id_permission')
                    ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}
