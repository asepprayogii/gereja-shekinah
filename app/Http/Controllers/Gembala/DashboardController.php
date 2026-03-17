<?php

namespace App\Http\Controllers\Gembala;

use App\Http\Controllers\Controller;
use App\Models\Renungan;
use App\Models\Pengumuman;
use App\Models\Kegiatan;
use App\Models\TukarJadwal;
use Illuminate\Http\Request;
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
        $totalRenungan    = Renungan::where('user_id', auth()->id())->count();
        $totalPengumuman  = Pengumuman::where('user_id', auth()->id())->count();
        $kegiatanMingguIni = Kegiatan::mingguIni()->count();
        $renunganTerbaru  = Renungan::where('user_id', auth()->id())
                            ->orderBy('tanggal_publish', 'desc')
                            ->take(3)->get();

        return view('gembala.dashboard', compact(
            'totalRenungan', 'totalPengumuman',
            'kegiatanMingguIni', 'renunganTerbaru'
        ));
    }

    public function renungan()
    {
        $renungan = Renungan::where('user_id', auth()->id())
                    ->orderBy('tanggal_publish', 'desc')
                    ->paginate(10);
        return view('gembala.renungan', compact('renungan'));
    }

    public function storeRenungan(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        Renungan::create([
            'user_id'         => auth()->id(),
            'judul'           => $request->judul,
            'ayat'            => $request->ayat,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('gembala.renungan')
            ->with('success', 'Renungan berhasil disimpan!');
    }

    public function editRenungan($id)
    {
        $renungan = Renungan::where('user_id', auth()->id())->findOrFail($id);
        return view('gembala.renungan-edit', compact('renungan'));
    }

    public function updateRenungan(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        $renungan = Renungan::where('user_id', auth()->id())->findOrFail($id);
        $renungan->update([
            'judul'           => $request->judul,
            'ayat'            => $request->ayat,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('gembala.renungan')
            ->with('success', 'Renungan berhasil diupdate!');
    }

    public function destroyRenungan($id)
    {
        Renungan::where('user_id', auth()->id())->findOrFail($id)->delete();
        return redirect()->route('gembala.renungan')
            ->with('success', 'Renungan berhasil dihapus!');
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::where('user_id', auth()->id())
                      ->orderBy('tanggal_publish', 'desc')
                      ->paginate(10);
        return view('gembala.pengumuman', compact('pengumuman'));
    }

    public function storePengumuman(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        Pengumuman::create([
            'user_id'         => auth()->id(),
            'judul'           => $request->judul,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('gembala.pengumuman')
            ->with('success', 'Pengumuman berhasil disimpan!');
    }

    public function jadwal()
    {
        $kegiatan = Kegiatan::orderBy('tanggal', 'desc')->paginate(10);
        return view('gembala.jadwal', compact('kegiatan'));
    }

    public function profil()
    {
        return view('gembala.profil');
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

        return redirect()->route('gembala.profil')
            ->with('success', 'Profil berhasil diupdate!');
    }
}
