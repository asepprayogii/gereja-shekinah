<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlideshow extends Model
{
    protected $table = 'hero_slideshow';

    protected $fillable = [
        'foto', 'judul', 'deskripsi', 'urutan', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}