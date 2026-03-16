<?php

namespace App\Http\Controllers\Pelayan;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelayanan;
use App\Models\JadwalIbadahMinggu;
use App\Models\TukarJadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $nama   = auth()->user()->name;

        // Jadwal dari jadwal_pelayanan (sistem lama)
        $jadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->whereHas('kegiatan', function ($q) {
                $q->where('tanggal', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

        // Jadwal dari jadwal_ibadah_minggu (sistem baru) — cari berdasarkan nama
        $jadwalMinggu = JadwalIbadahMinggu::where('nama_pelayan', $nama)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->take(5)->get();

        $totalJadwalPelayanan = JadwalPelayanan::where('user_id', $userId)->count();
        $totalJadwalMinggu    = JadwalIbadahMinggu::where('nama_pelayan', $nama)->count();
        $totalJadwal          = $totalJadwalPelayanan + $totalJadwalMinggu;

        $requestPending = TukarJadwal::where('pemohon_id', $userId)
            ->where('status', 'menunggu')->count();

        return view('pelayan.dashboard', compact(
            'jadwalPelayanan', 'jadwalMinggu',
            'totalJadwal', 'requestPending'
        ));
    }

    public function jadwal()
    {
        $userId = auth()->id();
        $nama   = auth()->user()->name;

        // Dari jadwal_pelayanan
        $jadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_pelayanan');

        // Dari jadwal_ibadah_minggu
        $jadwalMinggu = JadwalIbadahMinggu::where('nama_pelayan', $nama)
            ->orderBy('tanggal', 'desc')
            ->paginate(10, ['*'], 'page_minggu');

        $posisiList = JadwalIbadahMinggu::$posisiList;

        return view('pelayan.jadwal', compact(
            'jadwalPelayanan', 'jadwalMinggu', 'posisiList'
        ));
    }

    public function tukarJadwal(Request $request)
    {
        $userId = auth()->id();
        $nama   = auth()->user()->name;

        // Jadwal pelayanan mendatang (sistem lama)
        $myJadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->whereHas('kegiatan', function ($q) {
                $q->where('tanggal', '>=', now()->toDateString());
            })->get();

        // Jadwal ibadah minggu mendatang (sistem baru)
        $myJadwalMinggu = JadwalIbadahMinggu::where('nama_pelayan', $nama)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')->get();

        $requests = TukarJadwal::with(['jadwal.kegiatan', 'pengganti'])
            ->where('pemohon_id', $userId)
            ->orderBy('created_at', 'desc')->get();

        $pelayan = User::whereIn('role', ['pelayan', 'gembala'])
            ->where('id', '!=', $userId)
            ->orderBy('name')->get();

        $posisiList = JadwalIbadahMinggu::$posisiList;

        return view('pelayan.tukar-jadwal', compact(
            'myJadwalPelayanan', 'myJadwalMinggu',
            'requests', 'pelayan', 'posisiList'
        ));
    }

        public function storeTukarJadwal(Request $request)
    {
        $request->validate([
            'tipe'            => 'required|in:pelayanan,minggu',
            'jadwal_id'       => 'nullable|exists:jadwal_pelayanan,id',
            'jadwal_minggu_id'=> 'nullable|exists:jadwal_ibadah_minggu,id',
            'alasan'          => 'required|string|max:500',
            'pengganti_id'    => 'nullable|exists:users,id',
        ]);

        // Validasi sesuai tipe
        if ($request->tipe === 'pelayanan') {
            if (!$request->jadwal_id) {
                return back()->with('error', 'Pilih jadwal pelayanan!');
            }
            // Pastikan jadwal milik user ini
            JadwalPelayanan::where('id', $request->jadwal_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            TukarJadwal::create([
                'tipe'         => 'pelayanan',
                'jadwal_id'    => $request->jadwal_id,
                'pemohon_id'   => auth()->id(),
                'pengganti_id' => $request->pengganti_id,
                'alasan'       => $request->alasan,
                'status'       => 'menunggu',
            ]);

        } else {
            if (!$request->jadwal_minggu_id) {
                return back()->with('error', 'Pilih jadwal ibadah minggu!');
            }
            // Pastikan jadwal ini memang milik user (nama sama)
            $jadwal = JadwalIbadahMinggu::where('id', $request->jadwal_minggu_id)
                ->where('nama_pelayan', auth()->user()->name)
                ->firstOrFail();

            TukarJadwal::create([
                'tipe'             => 'minggu',
                'jadwal_minggu_id' => $request->jadwal_minggu_id,
                'pemohon_id'       => auth()->id(),
                'pengganti_id'     => $request->pengganti_id,
                'alasan'           => $request->alasan,
                'status'           => 'menunggu',
            ]);
        }

        return redirect()->route('pelayan.tukar-jadwal')
            ->with('success', 'Request tukar jadwal berhasil dikirim!');
    }

    public function profil()
    {
        return view('pelayan.profil');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'no_hp' => $request->no_hp,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if (auth()->user()->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(auth()->user()->foto);
            }
            $data['foto'] = $request->file('foto')->store('profil', 'public');
        }

        auth()->user()->update($data);

        return redirect()->route('pelayan.profil')
            ->with('success', 'Profil berhasil diupdate!');
    }
}