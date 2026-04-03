<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MangaLike extends Model
{
    use HasFactory;
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


    protected $fillable = [
        'post_id',
        'user_id',
    ];

    public $timestamps = false;
}
