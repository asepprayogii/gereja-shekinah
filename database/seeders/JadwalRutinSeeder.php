<?php

namespace Database\Seeders;

use App\Models\JadwalRutin;
use Illuminate\Database\Seeder;

class JadwalRutinSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_hari' => 'Senin', 'hari_urutan' => 1, 'nama_kegiatan' => 'Ibadah Kaum Wanita', 'jam_mulai' => '16:00:00'],
            ['nama_hari' => 'Selasa', 'hari_urutan' => 2, 'nama_kegiatan' => 'Ibadah Kemah Pniel', 'jam_mulai' => '19:00:00'],
            ['nama_hari' => 'Rabu', 'hari_urutan' => 3, 'nama_kegiatan' => 'Ibadah Mahanaim', 'jam_mulai' => '19:00:00'],
            ['nama_hari' => 'Kamis', 'hari_urutan' => 4, 'nama_kegiatan' => 'Ibadah Filadelfia', 'jam_mulai' => '19:00:00'],
            ['nama_hari' => 'Jumat', 'hari_urutan' => 5, 'nama_kegiatan' => 'Doa Syafaat', 'jam_mulai' => '17:00:00'],
            ['nama_hari' => 'Jumat', 'hari_urutan' => 5, 'nama_kegiatan' => 'Latihan Musik', 'jam_mulai' => '19:00:00'],
            ['nama_hari' => 'Sabtu', 'hari_urutan' => 6, 'nama_kegiatan' => 'Ibadah Pemuda', 'jam_mulai' => '19:00:00'],
            ['nama_hari' => 'Minggu', 'hari_urutan' => 7, 'nama_kegiatan' => 'Sekolah Minggu', 'jam_mulai' => '10:00:00'],
            ['nama_hari' => 'Minggu', 'hari_urutan' => 7, 'nama_kegiatan' => 'Ibadah Raya', 'jam_mulai' => '10:00:00'],
        ];

        foreach ($data as $item) {
            JadwalRutin::create($item);
        }
    }
}