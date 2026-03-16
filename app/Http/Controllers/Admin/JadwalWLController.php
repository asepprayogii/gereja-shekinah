<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalWL;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalWlController extends Controller
{
    /**
     * Tampilkan halaman jadwal WL
     */
    public function index()
    {
        // Ambil kegiatan tengah minggu (bukan Ibadah Raya Minggu)
        // Filter: is_active = true, dan bukan jenis 'Ibadah Raya'
        $kegiatan = Kegiatan::where('is_active', true)
            ->whereNotIn('jenis', ['Ibadah Raya', 'Ibadah Minggu'])
            ->whereDate('tanggal', '>=', now()->startOfWeek())
            ->whereDate('tanggal', '<=', now()->endOfWeek()->addWeeks(2))
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();

        // Ambil semua WL yang sudah di-assign, index by kegiatan_id
        $jadwalWL = JadwalWL::with('kegiatan')
            ->get()
            ->pluck('nama_wl', 'kegiatan_id');

        // Ambil daftar pelayan untuk datalist autocomplete
        $pelayan = User::whereIn('role', ['pelayan', 'gembala'])
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-wl', compact('kegiatan', 'jadwalWL', 'pelayan'));
    }

    /**
     * Simpan/Update WL untuk suatu kegiatan
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'nama_wl'     => 'required|string|max:255',
        ]);

        // Update or Create (jika sudah ada, update; jika belum, buat baru)
        JadwalWL::updateOrCreate(
            ['kegiatan_id' => $request->kegiatan_id],
            ['nama_wl' => trim($request->nama_wl)]
        );

        return back()->with('success', 'WL berhasil ditetapkan!');
    }

    /**
     * Hapus WL dari suatu kegiatan
     */
    public function destroy($id)
    {
        $wl = JadwalWL::findOrFail($id);
        $wl->delete();

        return back()->with('success', 'WL berhasil dihapus!');
    }
}