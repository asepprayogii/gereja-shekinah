<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class GaleriController extends Controller
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

    public function index()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.galeri', compact('galeri'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto'  => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'judul' => 'nullable|string|max:255',
        ]);

        $cloudinary = $this->getCloudinary();
        $result = $cloudinary->uploadApi()->upload(
            $request->file('foto')->getRealPath(),
            ['folder' => 'gereja-shekinah/galeri']
        );

        Galeri::create([
            'judul'            => $request->judul,
            'foto'             => $result['secure_url'],
            'kategori'         => $request->kategori,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil diupload!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if (str_starts_with($galeri->foto, 'http')) {
            $path = parse_url($galeri->foto, PHP_URL_PATH);
            preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
            if (!empty($matches[1])) {
                $cloudinary = $this->getCloudinary();
                $cloudinary->uploadApi()->destroy($matches[1]);
            }
        }

        $galeri->delete();

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil dihapus!');
    }
}
