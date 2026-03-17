<?php

namespace App\Http\Controllers\Pelayan;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelayanan;
use App\Models\JadwalIbadahMinggu;
use App\Models\TukarJadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class DashboardController extends Controller
{
    private function getCloudinary()
    {
        return new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key'    => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
                'url' => ['secure' => true]
            ])
        );
    }

    private function hapusDariCloudinary($fotoUrl)
    {
        if ($fotoUrl && str_starts_with($fotoUrl, 'http')) {
            $path = parse_url($fotoUrl, PHP_URL_PATH);
            preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
            if (!empty($matches[1])) {
                $this->getCloudinary()->uploadApi()->destroy($matches[1]);
            }
        }
    }

    public function index()
    {
        $userId = auth()->id();
        $nama   = auth()->user()->name;

        $jadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->whereHas('kegiatan', function ($q) {
                $q->where('tanggal', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->take(5)->get();

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

        $jadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_pelayanan');

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

        $myJadwalPelayanan = JadwalPelayanan::with('kegiatan')
            ->where('user_id', $userId)
            ->whereHas('kegiatan', function ($q) {
                $q->where('tanggal', '>=', now()->toDateString());
            })->get();

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
            'tipe'             => 'required|in:pelayanan,minggu',
            'jadwal_id'        => 'nullable|exists:jadwal_pelayanan,id',
            'jadwal_minggu_id' => 'nullable|exists:jadwal_ibadah_minggu,id',
            'alasan'           => 'required|string|max:500',
            'pengganti_id'     => 'nullable|exists:users,id',
        ]);

        if ($request->tipe === 'pelayanan') {
            if (!$request->jadwal_id) {
                return back()->with('error', 'Pilih jadwal pelayanan!');
            }
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
            JadwalIbadahMinggu::where('id', $request->jadwal_minggu_id)
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
            $this->hapusDariCloudinary(auth()->user()->foto);
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/profil']
            );
            $data['foto'] = $result['secure_url'];
        }

        auth()->user()->update($data);

        return redirect()->route('pelayan.profil')
            ->with('success', 'Profil berhasil diupdate!');
    }
}
