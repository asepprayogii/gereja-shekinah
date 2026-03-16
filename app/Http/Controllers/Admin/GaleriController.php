<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $path = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul'           => $request->judul,
            'foto'            => $path,
            'kategori'        => $request->kategori,
            'tanggal_kegiatan'=> $request->tanggal_kegiatan,
        ]);

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil diupload!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        Storage::disk('public')->delete($galeri->foto);
        $galeri->delete();

        return redirect()->route('admin.galeri')
            ->with('success', 'Foto berhasil dihapus!');
    }
}