<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renungan;
use App\Models\Pengumuman;
use App\Models\Jemaat;
use App\Models\Kegiatan;
use App\Models\User;
use App\Models\Galeri;
use App\Models\Musik;
use App\Models\TukarJadwal;
use App\Models\JadwalPelayanan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalJemaat     = Jemaat::aktif()->count();
        $totalPelayan    = User::whereIn('role', ['pelayan', 'gembala'])->count();
        $totalRenungan   = Renungan::published()->count();
        $totalPengumuman = Pengumuman::published()->count();
        $totalGaleri     = Galeri::count();
        $totalMusik      = Musik::count();

        // Kegiatan minggu ini
        $kegiatanMingguIni = Kegiatan::mingguIni()
            ->orderBy('tanggal')->orderBy('jam_mulai')->get();

        // Ultah minggu ini
        $ultah = Jemaat::aktif()->ultahMingguIni()
            ->orderByRaw("DATE_FORMAT(tanggal_lahir, '%m-%d')")
            ->get();

        // Request tukar jadwal pending
        $tukarPending = TukarJadwal::where('status', 'menunggu')->count();

        // Renungan terbaru
        $renunganTerbaru = Renungan::with('penulis')
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        // Jemaat terbaru
        $jemaatTerbaru = Jemaat::orderBy('created_at', 'desc')
            ->take(5)->get();

        return view('admin.dashboard', compact(
            'totalJemaat', 'totalPelayan', 'totalRenungan',
            'totalPengumuman', 'totalGaleri', 'totalMusik',
            'kegiatanMingguIni', 'ultah', 'tukarPending',
            'renunganTerbaru', 'jemaatTerbaru'
        ));
    }
}