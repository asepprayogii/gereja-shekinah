<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalIbadahMinggu;
use App\Models\User;

class JadwalController extends Controller
{
    public function index()
    {
        $pelayan = User::whereIn('role', ['pelayan', 'gembala'])
            ->orderBy('name')
            ->get();

        $posisiList = JadwalIbadahMinggu::$posisiList;

        $jadwal = JadwalIbadahMinggu::latest('tanggal')->paginate(10);

        return view('admin.jadwal', compact('pelayan', 'posisiList', 'jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'      => 'required|date',
            'posisi'       => 'required|string',
            'nama_pelayan' => 'required|string|max:255',
        ]);

        JadwalIbadahMinggu::create([
            'tanggal'      => $request->tanggal,
            'posisi'       => $request->posisi,
            'nama_pelayan' => $request->nama_pelayan,
            'urutan'       => $request->urutan ?? 0,
            'is_visible'   => true,
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function destroy($id)
    {
        JadwalIbadahMinggu::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}