cat > app/Http/Controllers/Admin/GaleriController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class GaleriController extends Controller
{
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

        $uploaded = Cloudinary::upload($request->file('foto')->getRealPath(), [
            'folder' => 'gereja-shekinah/galeri'
        ]);

        Galeri::create([
            'judul'            => $request->judul,
            'foto'             => $uploaded->getSecurePath(),
            'kategori'         => $request->kategori,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
        ]);

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil diupload!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus dari Cloudinary pakai public_id
        $publicId = pathinfo(parse_url($galeri->foto, PHP_URL_PATH), PATHINFO_FILENAME);
        Cloudinary::destroy('gereja-shekinah/galeri/' . $publicId);

        $galeri->delete();

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil dihapus!');
    }
}
EOF