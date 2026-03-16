<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutGereja extends Model
{
    protected $table = 'about_gereja';

    protected $fillable = [
        'nama_gereja', 'sejarah', 'visi', 'misi',
        'instagram', 'youtube', 'facebook', 'tiktok',
        'alamat', 'maps_embed', 'no_telp',
    ];

    public static function getData()
    {
        $data = static::first();
        if (!$data) {
            $data = static::create([
                'nama_gereja' => 'GPdI Jemaat Shekinah Pangkalan Buntu',
            ]);
        }
        return $data;
    }
}