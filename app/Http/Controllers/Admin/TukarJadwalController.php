<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TukarJadwal;
use App\Models\JadwalPelayanan;
use App\Models\JadwalIbadahMinggu;
use Illuminate\Http\Request;

class TukarJadwalController extends Controller
{
    public function index()
    {
        $requests = TukarJadwal::with([
                'jadwal.kegiatan',
                'jadwalMinggu',
                'pemohon',
                'pengganti'
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.tukar-jadwal', compact('requests'));
    }

    public function approve(Request $request, $id)
    {
        $tukar = TukarJadwal::with(['jadwal', 'jadwalMinggu'])->findOrFail($id);

        $tukar->update([
            'status'        => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Kalau ada pengganti, update jadwal
        if ($tukar->pengganti_id) {
            if ($tukar->tipe === 'pelayanan' && $tukar->jadwal) {
                // Update jadwal_pelayanan ke user pengganti
                $tukar->jadwal->update(['user_id' => $tukar->pengganti_id]);

            } elseif ($tukar->tipe === 'minggu' && $tukar->jadwalMinggu) {
                // Update nama_pelayan ke nama pengganti
                $tukar->jadwalMinggu->update([
                    'nama_pelayan' => $tukar->pengganti->name
                ]);
            }
        }

        return redirect()->route('admin.tukar-jadwal')
            ->with('success', 'Request tukar jadwal disetujui!');
    }

    public function reject(Request $request, $id)
    {
        TukarJadwal::findOrFail($id)->update([
            'status'        => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.tukar-jadwal')
            ->with('success', 'Request tukar jadwal ditolak!');
    }
}