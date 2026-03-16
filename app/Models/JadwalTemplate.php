<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalTemplate extends Model
{
    protected $table = 'jadwal_template';

    protected $fillable = [
        'hari',           // 0=Minggu, 1=Senin, ..., 6=Sabtu (sesuai data lama)
        'nama_hari',      // String: 'Senin', 'Selasa', dll
        'nama_kegiatan',
        'jenis',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'warna',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    /**
     * Mapping hari (0=Minggu, 1=Senin, ..., 6=Sabtu)
     * Sesuai dengan data existing di database
     */
    public static $namaHari = [
        0 => 'Minggu',
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
    ];

    /**
     * Urutan hari untuk sorting (Senin=1 sampai Minggu=7)
     * Digunakan untuk mengurutkan tampilan Senin-Minggu
     */
    public static $urutanHari = [
        1 => 1,  // Senin
        2 => 2,  // Selasa
        3 => 3,  // Rabu
        4 => 4,  // Kamis
        5 => 5,  // Jumat
        6 => 6,  // Sabtu
        0 => 7,  // Minggu (jadi terakhir)
    ];

    /**
     * Accessor untuk nama hari
     */
    public function getNamaHariAttribute()
    {
        return self::$namaHari[$this->hari] ?? '-';
    }

    /**
     * Scope untuk hanya ambil template aktif (tampil di publik)
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk sorting Senin-Minggu
     */
    public function scopeUrutSeninMinggu($query)
    {
        return $query->orderByRaw("CASE hari 
            WHEN 1 THEN 1  -- Senin
            WHEN 2 THEN 2  -- Selasa
            WHEN 3 THEN 3  -- Rabu
            WHEN 4 THEN 4  -- Kamis
            WHEN 5 THEN 5  -- Jumat
            WHEN 6 THEN 6  -- Sabtu
            WHEN 0 THEN 7  -- Minggu
            ELSE 8 END");
    }

    /**
     * Helper untuk mendapatkan urutan hari (1-7)
     */
    public function getUrutanHariAttribute()
    {
        return self::$urutanHari[$this->hari] ?? 8;
    }
}