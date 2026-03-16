<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jemaat extends Model
{
    protected $table = 'jemaat';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'status_pernikahan',
        'pekerjaan',
        'tanggal_baptis',
        'tanggal_sidi',
        'nama_keluarga',
        'foto',
        'status_aktif',
        'catatan',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_baptis' => 'date',
        'tanggal_sidi'   => 'date',
        'status_aktif'   => 'boolean',
    ];

    // Sapaan otomatis berdasarkan jenis_kelamin
    public function getSapaanAttribute(): string
    {
        return $this->jenis_kelamin === 'Laki-laki' ? 'Sdr.' : 'Sdri.';
    }

    public function scopeAktif($query)
    {
        return $query->where('status_aktif', true);
    }

    public function scopeUltahMingguIni($query)
    {
        $start   = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $end     = Carbon::now()->endOfWeek(Carbon::SATURDAY);
        $startMD = $start->format('m-d');
        $endMD   = $end->format('m-d');

        return $query->whereNotNull('tanggal_lahir')
            ->whereRaw(
                "DATE_FORMAT(tanggal_lahir, '%m-%d') BETWEEN ? AND ?",
                [$startMD, $endMD]
            );
    }
}