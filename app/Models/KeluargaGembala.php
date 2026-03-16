<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeluargaGembala extends Model
{
    protected $table = 'keluarga_gembala';

    protected $fillable = [
        'nama', 'peran', 'foto', 'bio', 'urutan',
    ];
}