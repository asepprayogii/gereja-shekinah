<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalTemplate;

class JadwalTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            ['nama_kegiatan' => 'Ibadah Kaum Wanita',  'jenis' => 'Ibadah', 'hari' => 1, 'jam_mulai' => '16:00', 'jam_selesai' => '18:00', 'warna' => '#ec4899'],
            ['nama_kegiatan' => 'Ibadah Kemah Pniel',  'jenis' => 'Ibadah', 'hari' => 2, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00', 'warna' => '#8b5cf6'],
            ['nama_kegiatan' => 'Ibadah Mahanaim',     'jenis' => 'Ibadah', 'hari' => 3, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00', 'warna' => '#3b82f6'],
            ['nama_kegiatan' => 'Ibadah Filadelfia',   'jenis' => 'Ibadah', 'hari' => 4, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00', 'warna' => '#06b6d4'],
            ['nama_kegiatan' => 'Doa Syafaat',         'jenis' => 'Doa',    'hari' => 5, 'jam_mulai' => '17:00', 'jam_selesai' => '19:00', 'warna' => '#f59e0b'],
            ['nama_kegiatan' => 'Latihan Musik',       'jenis' => 'Latihan','hari' => 5, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00', 'warna' => '#10b981'],
            ['nama_kegiatan' => 'Ibadah Pemuda',       'jenis' => 'Youth',  'hari' => 6, 'jam_mulai' => '19:00', 'jam_selesai' => '21:00', 'warna' => '#f97316'],
            ['nama_kegiatan' => 'Sekolah Minggu',      'jenis' => 'Ibadah', 'hari' => 0, 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'warna' => '#84cc16'],
            ['nama_kegiatan' => 'Ibadah Raya',         'jenis' => 'Ibadah', 'hari' => 0, 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'warna' => '#5b7fa6'],
        ];

        foreach ($templates as $t) {
            JadwalTemplate::create($t);
        }
    }
}
