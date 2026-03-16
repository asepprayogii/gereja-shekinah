<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'user_id', 'judul', 'isi',
        'tanggal_publish', 'is_published',
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
}