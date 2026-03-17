<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeluargaGembala;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class KeluargaGembalaController extends Controller
{
    private const PERAN_LIST = [
        ['peran' => 'Gembala',     'urutan' => 1],
        ['peran' => 'Ibu Gembala', 'urutan' => 2],
        ['peran' => 'Anak 1',      'urutan' => 3],
        ['peran' => 'Anak 2',      'urutan' => 4],
        ['peran' => 'Anak 3',      'urutan' => 5],
    ];

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

    public function index()
    {
        $anakLama = KeluargaGembala::where('peran', 'Anak Gembala')->orderBy('urutan')->get();
        foreach ($anakLama as $i => $anak) {
            $nomorAnak = $i + 1;
            if ($nomorAnak <= 3) {
                $anak->update(['peran' => 'Anak ' . $nomorAnak]);
            }
        }

        foreach (self::PERAN_LIST as $slot) {
            KeluargaGembala::firstOrCreate(
                ['peran' => $slot['peran']],
                ['nama' => '', 'bio' => null, 'foto' => null, 'urutan' => $slot['urutan']]
            );
        }

        $keluarga = KeluargaGembala::orderBy('urutan')->get();
        return view('admin.gembala', compact('keluarga'));
    }

    public function update(Request $request, $id)
    {
        $anggota = KeluargaGembala::findOrFail($id);

        $request->validate([
            'nama' => 'nullable|string|max:255',
            'bio'  => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'nama' => $request->nama ?? '',
            'bio'  => $request->bio,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama dari Cloudinary jika ada
            if ($anggota->foto && str_starts_with($anggota->foto, 'http')) {
                $path = parse_url($anggota->foto, PHP_URL_PATH);
                preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
                if (!empty($matches[1])) {
                    $this->getCloudinary()->uploadApi()->destroy($matches[1]);
                }
            }

            // Upload foto baru ke Cloudinary
            $result = $this->getCloudinary()->uploadApi()->upload(
                $request->file('foto')->getRealPath(),
                ['folder' => 'gereja-shekinah/gembala']
            );
            $data['foto'] = $result['secure_url'];
        }

        if ($request->boolean('hapus_foto') && $anggota->foto) {
            if (str_starts_with($anggota->foto, 'http')) {
                $path = parse_url($anggota->foto, PHP_URL_PATH);
                preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
                if (!empty($matches[1])) {
                    $this->getCloudinary()->uploadApi()->destroy($matches[1]);
                }
            }
            $data['foto'] = null;
        }

        $anggota->update($data);

        return redirect()->route('admin.gembala')
            ->with('success', 'Data ' . $anggota->peran . ' berhasil diupdate!');
    }
}
