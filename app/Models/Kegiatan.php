<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'jenis',
        'warna',
        'is_active',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ✅ TAMBAHKAN SCOPE INI:
    public function scopeMingguIni(Builder $query): Builder
    {
        return $query->whereDate('tanggal', '>=', Carbon::now()->startOfWeek())
                    ->whereDate('tanggal', '<=', Carbon::now()->endOfWeek());
    }

    // Scope tambahan yang mungkin dibutuhkan:
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeHariIni(Builder $query): Builder
    {
        return $query->whereDate('tanggal', Carbon::today());
    }

    // Relasi ke JadwalWL
    public function jadwalWL()
    {
        return $this->hasOne(JadwalWL::class, 'kegiatan_id');
    }
}