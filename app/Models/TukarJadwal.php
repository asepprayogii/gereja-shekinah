<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TukarJadwal extends Model
{
    protected $table = 'tukar_jadwal';

    protected $fillable = [
        'jadwal_id', 'jadwal_minggu_id', 'tipe',
        'pemohon_id', 'pengganti_id',
        'alasan', 'status', 'catatan_admin',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalPelayanan::class, 'jadwal_id');
    }

    public function jadwalMinggu()
    {
        return $this->belongsTo(JadwalIbadahMinggu::class, 'jadwal_minggu_id');
    }

    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

    public function pengganti()
    {
        return $this->belongsTo(User::class, 'pengganti_id');
    }
}