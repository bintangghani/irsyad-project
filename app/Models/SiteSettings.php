<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_settings';
    protected $primaryKey = 'id_site_settings';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];
}
