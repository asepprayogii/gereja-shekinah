<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelayanan extends Model
{
    protected $table = 'jadwal_pelayanan';

    protected $fillable = [
        'user_id', 'kegiatan_id', 'posisi', 'catatan'
    ];

    public function pelayan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
