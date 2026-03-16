<?php

namespace Database\Seeders;

use App\Models\PosisiPelayanan;
use Illuminate\Database\Seeder;

class PosisiPelayananSeeder extends Seeder
{
    public function run(): void
    {
        $posisi = [
            // Vokal & Worship
            ['nama_posisi' => 'Praise Leader / Worship Leader', 'kategori' => 'Vokal & Worship'],
            ['nama_posisi' => 'Singer / Vocalist',              'kategori' => 'Vokal & Worship'],

            // Musik
            ['nama_posisi' => 'Drum',                           'kategori' => 'Musik'],
            ['nama_posisi' => 'Gitar',                          'kategori' => 'Musik'],
            ['nama_posisi' => 'Bass',                           'kategori' => 'Musik'],
            ['nama_posisi' => 'Piano / Keyboard',               'kategori' => 'Musik'],

            // Worship Arts
            ['nama_posisi' => 'Tamborin',                       'kategori' => 'Worship Arts'],
            ['nama_posisi' => 'Banners / Flag',                 'kategori' => 'Worship Arts'],

            // Pelayanan Umum
            ['nama_posisi' => 'Multimedia / Proyektor & Sound', 'kategori' => 'Pelayanan Umum'],
            ['nama_posisi' => 'Penerima Tamu',                  'kategori' => 'Pelayanan Umum'],
            ['nama_posisi' => 'Pembawa Persembahan',            'kategori' => 'Pelayanan Umum'],
            ['nama_posisi' => 'Perjamuan Kudus',                'kategori' => 'Pelayanan Umum'],
        ];

        foreach ($posisi as $p) {
            PosisiPelayanan::create($p);
        }
    }
}
