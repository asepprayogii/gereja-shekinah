<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalIbadahMinggu extends Model
{
    protected $table = 'jadwal_ibadah_minggu';

    protected $fillable = [
        'tanggal', 'posisi', 'nama_pelayan', 'urutan', 'is_visible',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'is_visible' => 'boolean',
    ];

    public static $posisiList = [
        'worship_leader'  => 'Worship Leader',
        'singer_1'        => 'Singer 1',
        'singer_2'        => 'Singer 2',
        'singer_3'        => 'Singer 3',
        'keyboard'        => 'Keyboard',
        'gitar'           => 'Gitar',
        'bass'            => 'Bass',
        'drum'            => 'Drum',
        'tamborin_1'      => 'Tamborin 1',
        'tamborin_2'      => 'Tamborin 2',
        'tamborin_3'      => 'Tamborin 3',
        'tamborin_4'      => 'Tamborin 4',
        'tamborin_5'      => 'Tamborin 5',
        'flag_1'          => 'Flag/Banner 1',
        'flag_2'          => 'Flag/Banner 2',
        'penerima_tamu_1' => 'Penerima Tamu 1',
        'penerima_tamu_2' => 'Penerima Tamu 2',
        'persembahan_1'   => 'Persembahan 1',
        'persembahan_2'   => 'Persembahan 2',
        'perjamuan_1'     => 'Perjamuan Kudus 1',
        'perjamuan_2'     => 'Perjamuan Kudus 2',
        'perjamuan_3'     => 'Perjamuan Kudus 3',
        'multimedia'      => 'Multimedia',
        'sound'           => 'Sound',
    ];

    public static $grupPosisi = [
        'Worship Leader'  => ['worship_leader'],
        'Singer'          => ['singer_1', 'singer_2', 'singer_3'],
        'Musik'           => ['keyboard', 'gitar', 'bass', 'drum'],
        'Tamborin'        => ['tamborin_1', 'tamborin_2', 'tamborin_3', 'tamborin_4', 'tamborin_5'],
        'Flag / Banner'   => ['flag_1', 'flag_2'],
        'Penerima Tamu'   => ['penerima_tamu_1', 'penerima_tamu_2'],
        'Persembahan'     => ['persembahan_1', 'persembahan_2'],
        'Perjamuan Kudus' => ['perjamuan_1', 'perjamuan_2', 'perjamuan_3'],
        'Sound & Teknis'  => ['multimedia', 'sound'],
    ];
}