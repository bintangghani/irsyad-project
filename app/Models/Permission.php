<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory, HasUuids, SoftDeletes; 
    
    protected $table = 'permission';
    protected $primaryKey = 'id_permission';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'id_permission', 'id_role')
                    ->withTimestamps();
    }
}
