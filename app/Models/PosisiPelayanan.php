<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosisiPelayanan extends Model
{
    protected $table = 'posisi_pelayanan';

    protected $fillable = [
        'nama_posisi', 'kategori', 'keterangan'
    ];
}