<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'books';
    protected $fillable = [
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit'
    ];

    protected $hidden = [];
}
