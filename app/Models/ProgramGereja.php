<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramGereja extends Model
{
    protected $table = 'program_gereja';

    protected $fillable = [
        'nama_program', 'deskripsi', 'foto',
        'link_info', 'urutan', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}