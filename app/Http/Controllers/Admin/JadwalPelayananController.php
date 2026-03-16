<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelayanan;
use App\Models\Kegiatan;
use App\Models\User;
use App\Models\PosisiPelayanan;
use Illuminate\Http\Request;

class JadwalPelayananController extends Controller
{
    public function index()
    {
        $jadwal   = JadwalPelayanan::with(['pelayan', 'kegiatan'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->get();
        $pelayan  = User::whereIn('role', ['pelayan', 'gembala'])
                    ->orderBy('name')->get();
        $posisi   = PosisiPelayanan::orderBy('kategori')->get();

        return view('admin.jadwal', compact('jadwal', 'kegiatan', 'pelayan', 'posisi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'kegiatan_id' => 'required|exists:kegiatan,id',
            'posisi'      => 'required|string|max:100',
        ]);

        // Cek duplikat
        $exists = JadwalPelayanan::where('user_id', $request->user_id)
                    ->where('kegiatan_id', $request->kegiatan_id)
                    ->where('posisi', $request->posisi)
                    ->exists();

        if ($exists) {
            return redirect()->route('admin.jadwal')
                ->with('error', 'Pelayan sudah terdaftar di posisi ini untuk kegiatan ini!');
        }

        JadwalPelayanan::create([
            'user_id'     => $request->user_id,
            'kegiatan_id' => $request->kegiatan_id,
            'posisi'      => $request->posisi,
            'catatan'     => $request->catatan,
        ]);

        return redirect()->route('admin.jadwal')
            ->with('success', 'Jadwal pelayanan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        JadwalPelayanan::findOrFail($id)->delete();
        return redirect()->route('admin.jadwal')
            ->with('success', 'Jadwal pelayanan berhasil dihapus!');
    }
}