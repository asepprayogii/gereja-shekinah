<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeluargaGembala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeluargaGembalaController extends Controller
{
    private const PERAN_LIST = [
        ['peran' => 'Gembala',     'urutan' => 1],
        ['peran' => 'Ibu Gembala', 'urutan' => 2],
        ['peran' => 'Anak 1',      'urutan' => 3],
        ['peran' => 'Anak 2',      'urutan' => 4],
        ['peran' => 'Anak 3',      'urutan' => 5],
    ];

    public function index()
    {
        // Migrasi data lama: "Anak Gembala" → "Anak 1", "Anak 2", dst
        $anakLama = KeluargaGembala::where('peran', 'Anak Gembala')->orderBy('urutan')->get();
        foreach ($anakLama as $i => $anak) {
            $nomorAnak = $i + 1;
            if ($nomorAnak <= 3) {
                $anak->update(['peran' => 'Anak ' . $nomorAnak]);
            }
        }

        // Auto-generate slot yang belum ada
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
            if ($anggota->foto) Storage::disk('public')->delete($anggota->foto);
            $data['foto'] = $request->file('foto')->store('gembala', 'public');
        }

        if ($request->boolean('hapus_foto') && $anggota->foto) {
            Storage::disk('public')->delete($anggota->foto);
            $data['foto'] = null;
        }

        $anggota->update($data);

        return redirect()->route('admin.gembala')
            ->with('success', 'Data ' . $anggota->peran . ' berhasil diupdate!');
    }
}