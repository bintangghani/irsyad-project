<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bookmark extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'bookmarks';
    protected $primaryKey = 'id_bookmarks';
    protected $keyType = 'uuid';
    public $incrementing = false;
    protected $guarded = [];


    // protected $fillable = [
    //     'user_id',
    //     'book_id',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku','id_buku');
    }
}
