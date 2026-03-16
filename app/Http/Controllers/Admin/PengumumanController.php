<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::with('penulis')
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(10);
        return view('admin.pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
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

        return redirect()->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil disimpan!');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman-edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->update([
            'judul'           => $request->judul,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil diupdate!');
    }

    public function destroy($id)
    {
        Pengumuman::findOrFail($id)->delete();
        return redirect()->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil dihapus!');
    }
}