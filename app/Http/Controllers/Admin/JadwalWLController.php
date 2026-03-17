<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalWL;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalWLController extends Controller
{
    public function index()
    {
        $kegiatan = Kegiatan::where('is_active', true)
            ->whereNotIn('jenis', ['Ibadah Raya', 'Ibadah Minggu'])
            ->whereRaw('DAYOFWEEK(tanggal) BETWEEN 2 AND 7') // Senin(2) - Sabtu(7)
            ->where(function($q) {
                $q->whereRaw('LOWER(nama_kegiatan) NOT LIKE "%latihan musik%"')
                  ->whereRaw('LOWER(nama_kegiatan) NOT LIKE "%latihan%musik%"');
            })
            ->whereDate('tanggal', '>=', now()->startOfWeek())
            ->whereDate('tanggal', '<=', now()->endOfWeek()->addWeeks(2))
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        $jadwalWL = JadwalWL::with('kegiatan')
            ->get()
            ->pluck('nama_wl', 'kegiatan_id');

        $pelayan = User::whereIn('role', ['pelayan', 'gembala'])
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-wl', compact('kegiatan', 'jadwalWL', 'pelayan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_wl'     => 'required|string|max:255',
        ]);

        JadwalWL::updateOrCreate(
            ['kegiatan_id' => $request->kegiatan_id],
            ['nama_wl' => trim($request->nama_wl)]
        );

        return back()->with('success', 'WL berhasil ditetapkan!');
    }

    public function destroy($id)
    {
        $wl = JadwalWL::findOrFail($id);
        $wl->delete();

        return back()->with('success', 'WL berhasil dihapus!');
    }
}
