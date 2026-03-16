<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Renungan;
use Illuminate\Http\Request;

class RenunganController extends Controller
{
    public function index()
    {
        $renungan = Renungan::with('penulis')
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(10);
        return view('admin.renungan', compact('renungan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'ayat'            => 'nullable|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
            'is_published'    => 'nullable|boolean',
        ]);

        Renungan::create([
            'user_id'         => auth()->id(),
            'judul'           => $request->judul,
            'ayat'            => $request->ayat,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('admin.renungan')
            ->with('success', 'Renungan berhasil disimpan!');
    }

    public function edit($id)
    {
        $renungan = Renungan::findOrFail($id);
        return view('admin.renungan-edit', compact('renungan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'           => 'required|string|max:255',
            'ayat'            => 'nullable|string|max:255',
            'isi'             => 'required|string',
            'tanggal_publish' => 'required|date',
        ]);

        $renungan = Renungan::findOrFail($id);
        $renungan->update([
            'judul'           => $request->judul,
            'ayat'            => $request->ayat,
            'isi'             => $request->isi,
            'tanggal_publish' => $request->tanggal_publish,
            'is_published'    => $request->has('is_published'),
        ]);

        return redirect()->route('admin.renungan')
            ->with('success', 'Renungan berhasil diupdate!');
    }

    public function destroy($id)
    {
        Renungan::findOrFail($id)->delete();
        return redirect()->route('admin.renungan')
            ->with('success', 'Renungan berhasil dihapus!');
    }
}