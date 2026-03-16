<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul', 'foto', 'kategori', 'tanggal_kegiatan',
    ];

    protected $casts = [
        'tanggal_kegiatan' => 'date',
    ];
}