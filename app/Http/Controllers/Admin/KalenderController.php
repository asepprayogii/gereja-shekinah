<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\JadwalTemplate; // ← Sudah benar ✓
use Illuminate\Http\Request;
use Carbon\Carbon;

class KalenderController extends Controller
{
    public function index()
    {
        $this->generateMingguIni();
        $this->hapusKegiatanLalu();

        $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $weekEnd = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        // ← Filter: Tampilkan semua kegiatan (aktif & non-aktif) untuk admin
        $kegiatanMingguIni = Kegiatan::whereBetween('tanggal', [$weekStart, $weekEnd])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        // Template: urut Senin-Minggu
        $templates = JadwalTemplate::urutSeninMinggu()->get();

        return view('admin.kalender', compact('kegiatanMingguIni', 'templates', 'weekStart', 'weekEnd'));
    }

    private function generateMingguIni()
    {
        // ← Hanya ambil template yang AKTIF
        $templates = JadwalTemplate::where('is_active', true)->get();
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);

        $defaultHasWL = ['Doa Syafaat', 'Ibadah Kemah Pniel', 'Ibadah Mahanaim',
                        'Ibadah Filadelfia', 'Ibadah Pemuda', 'Ibadah Kaum Wanita'];

        foreach ($templates as $t) {
            // Mapping hari: 0=Minggu→6, 1=Senin→0, ..., 6=Sabtu→5
            $dayOffset = ($t->hari === 0) ? 6 : ($t->hari - 1);
            $tanggal = $startOfWeek->copy()->addDays($dayOffset);

            // ← Hanya buat jika belum ada, dan pastikan is_active = true
            $exists = Kegiatan::where('nama_kegiatan', $t->nama_kegiatan)
                ->whereDate('tanggal', $tanggal)
                ->exists();

            if (!$exists) {
                Kegiatan::create([
                    'nama_kegiatan' => $t->nama_kegiatan,
                    'jenis'         => $t->jenis,
                    'tanggal'       => $tanggal,
                    'jam_mulai'     => $t->jam_mulai,
                    'lokasi'        => $t->lokasi,
                    'has_wl'        => in_array($t->nama_kegiatan, $defaultHasWL),
                    'is_active'     => true, // ← Pastikan default aktif
                ]);
            }
        }
    }

    private function hapusKegiatanLalu()
    {
        $batas = Carbon::now()->startOfWeek(Carbon::MONDAY)->startOfDay();
        Kegiatan::where('tanggal', '<', $batas)->delete();
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'jenis'         => 'required|string|max:100',
            'tanggal'       => 'required|date',
            'jam_mulai'     => 'required',
        ]);

        Kegiatan::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jenis'         => $request->jenis,
            'tanggal'       => $request->tanggal,
            'jam_mulai'     => $request->jam_mulai,
            'lokasi'        => $request->lokasi,
            'keterangan'    => $request->keterangan,
            'has_wl'        => $request->has('has_wl'),
            'is_active'     => true, // ← Default aktif untuk publik
        ]);

        return redirect()->route('admin.kalender')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        return view('admin.kalender-edit', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jam_mulai' => 'required',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->update([
            'jam_mulai'  => $request->jam_mulai,
            'lokasi'     => $request->lokasi,
            'keterangan' => $request->keterangan,
            'has_wl'     => $request->has('has_wl'),
        ]);

        return redirect()->route('admin.kalender')->with('success', 'Kegiatan berhasil diupdate!');
    }

    public function destroy($id)
    {
        Kegiatan::findOrFail($id)->delete();
        return redirect()->route('admin.kalender')->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function toggleTemplate($id)
    {
        $template = JadwalTemplate::findOrFail($id);
        $newStatus = !$template->is_active;
        
        // Update status template
        $template->update(['is_active' => $newStatus]);
        
        // ← LOGIKA BARU: Jika di-nonaktifkan, sembunyikan juga kegiatan minggu ini yang berasal dari template ini
        if (!$newStatus) {
            $weekStart = Carbon::now()->startOfWeek(Carbon::MONDAY);
            $weekEnd = Carbon::now()->endOfWeek(Carbon::SUNDAY);
            
            Kegiatan::where('nama_kegiatan', $template->nama_kegiatan)
                ->whereBetween('tanggal', [$weekStart, $weekEnd])
                ->update(['is_active' => false]);
        }
        // Jika di-aktifkan, kegiatan baru akan digenerate otomatis saat index() dipanggil
        
        return redirect()->route('admin.kalender')->with('success', 'Status template diubah!');
    }

    public function updateTemplate(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:200',
            'jam_mulai'     => 'required',
        ]);

        JadwalTemplate::findOrFail($id)->update([
            'nama_kegiatan' => $request->nama_kegiatan,
            'jam_mulai'     => $request->jam_mulai,
        ]);

        return redirect()->route('admin.kalender')->with('success', 'Template berhasil diupdate!');
    }
}