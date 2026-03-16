<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Renungan extends Model
{
    protected $table = 'renungan'; // ← tambahkan ini

    protected $fillable = [
        'user_id', 'judul', 'ayat', 'isi', 'tanggal_publish', 'is_published'
    ];

    protected $casts = [
        'tanggal_publish' => 'date',
        'is_published'    => 'boolean',
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_publish', Carbon::today());
    }

    public function scopeMingguIni($query)
    {
        return $query->whereBetween('tanggal_publish', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek(),
        ]);
    }
}