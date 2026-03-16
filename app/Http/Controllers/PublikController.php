<?php

namespace App\Http\Controllers;

use App\Models\Renungan;
use App\Models\Pengumuman;
use App\Models\Kegiatan;
use App\Models\JadwalTemplate; // ← PERBAIKAN: JadwalTemplate, BUKAN Template
use App\Models\Jemaat;
use App\Models\HeroSlideshow;
use App\Models\Musik;
use App\Models\Galeri;
use App\Models\KeluargaGembala;
use App\Models\JadwalRutin;   // ← Import model
use App\Models\JadwalWL;      // ← Import model WL
use App\Models\ProgramGereja;
use App\Models\AboutGereja;
use App\Models\JadwalIbadahMinggu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublikController extends Controller
{
    public function beranda()
    {
        $slideshow  = HeroSlideshow::aktif()->orderBy('urutan')->get();
        $renungan   = Renungan::published()->hariIni()->first();
        $pengumuman = Pengumuman::published()
                        ->orderBy('tanggal_publish', 'desc')
                        ->take(3)->get();
        
        // Filter: Hanya kegiatan aktif yang tampil di publik
        $kegiatan = Kegiatan::mingguIni()
                        ->where('is_active', true)
                        ->orderBy('tanggal')
                        ->orderBy('jam_mulai')
                        ->get();
        
        // ← PERBAIKAN: Gunakan JadwalTemplate + scope urutSeninMinggu()
        $rutinAktif = JadwalTemplate::aktif()
                        ->urutSeninMinggu()
                        ->get();
        
        $ultah = Jemaat::aktif()->ultahMingguIni()
                        ->orderByRaw("DATE_FORMAT(tanggal_lahir, '%m-%d')")
                        ->get();

        return view('publik.beranda', compact(
            'slideshow', 'renungan', 'pengumuman', 'kegiatan', 'ultah', 'rutinAktif'
        ));
    }

    public function renungan()
    {
        $renungan = Renungan::published()
                    ->orderBy('tanggal_publish', 'desc')
                    ->paginate(9);
        return view('publik.renungan', compact('renungan'));
    }

    public function renunganDetail($id)
    {
        $renungan = Renungan::published()->findOrFail($id);
        return view('publik.renungan-detail', compact('renungan'));
    }

    public function jadwalIbadah()
    {
        // ✅ Jadwal Rutin (yang aktif) - gunakan fully qualified name atau import
        $rutinAktif = \App\Models\JadwalRutin::where('is_active', true)
            ->orderBy('hari_urutan')
            ->orderBy('jam_mulai')
            ->get();

        // ✅ Kegiatan Khusus (yang aktif, paginate)
        $kegiatan = \App\Models\Kegiatan::where('is_active', true)
            ->whereDate('tanggal', '>=', now()->startOfMonth())
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->paginate(20);

        // ✅ Ambil WL yang sudah di-assign, index by kegiatan_id
        $jadwalWL = \App\Models\JadwalWL::pluck('nama_wl', 'kegiatan_id');

        // ✅ Load relasi WL ke setiap kegiatan (opsional, untuk akses $k->jadwalWL)
        // $kegiatan->load(['jadwalWL']); 

        return view('publik.jadwal-ibadah', compact(
            'rutinAktif',
            'kegiatan',
            'jadwalWL'
        ));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::published()
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(9);
        return view('publik.pengumuman', compact('pengumuman'));
    }
    
    public function pengumumanDetail($id)
    {
        $pengumuman = \App\Models\Pengumuman::findOrFail($id);
        return view('publik.pengumuman-detail', compact('pengumuman'));
    }
    
    public function musik()
    {
        $musik = \App\Models\Musik::orderBy('urutan')->get();

        $playlist = $musik->map(function ($m) {
            return [
                'video_id'   => $m->video_id ?? '',
                'judul_lagu' => $m->judul_lagu ?? $m->judul ?? '',
                'penyanyi'   => $m->penyanyi ?? '',
                'thumbnail'  => 'https://img.youtube.com/vi/' . ($m->video_id ?? '') . '/hqdefault.jpg',
            ];
        })->values()->toArray();

        return view('publik.musik', compact('musik', 'playlist'));
    }

    public function galeri()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')->paginate(12);
        return view('publik.galeri', compact('galeri'));
    }

    public function gembala()
    {
        $gembala = KeluargaGembala::orderBy('urutan', 'asc')->get();
        return view('publik.gembala', compact('gembala'));
    }

    public function program()
    {
        $program = ProgramGereja::where('is_active', true)
                   ->orderBy('urutan')->get();
        return view('publik.program', compact('program'));
    }

    public function about()
    {
        $about = AboutGereja::getData();
        return view('publik.about', compact('about'));
    }

    public function lokasi()
    {
        $about = AboutGereja::getData();
        return view('publik.lokasi', compact('about'));
    }

    public function jadwalPelayan()
    {
        if (request('tanggal')) {
            $tanggalIbadah = Carbon::parse(request('tanggal'))->startOfWeek(Carbon::SUNDAY);
        } else {
            $today = Carbon::today();
            if ($today->dayOfWeek == Carbon::SUNDAY) {
                $tanggalIbadah = $today;
            } else {
                $tanggalIbadah = $today->next(Carbon::SUNDAY);
            }
        }

        $jadwal = JadwalIbadahMinggu::whereDate('tanggal', $tanggalIbadah)
            ->where('is_visible', true)
            ->where('nama_pelayan', '!=', '')
            ->orderBy('urutan')
            ->get();

        $posisiList = JadwalIbadahMinggu::$posisiList;
        $daftarMinggu = [];
        $start = $tanggalIbadah->copy()->subWeeks(2);

        for ($i = 0; $i < 8; $i++) {
            $daftarMinggu[] = $start->copy()->addWeeks($i);
        }

        $users = \App\Models\User::whereNotNull('foto')->get();

        return view('publik.jadwal-pelayan', compact(
            'jadwal', 'tanggalIbadah', 'daftarMinggu', 'posisiList', 'users'
        ));
    }
}