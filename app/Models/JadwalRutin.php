<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRutin extends Model
{
    protected $table = 'jadwal_rutin';

    protected $fillable = [
        'nama_hari',
        'hari_urutan',
        'nama_kegiatan',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'hari_urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}