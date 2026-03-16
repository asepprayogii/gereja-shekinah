<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutGereja;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = AboutGereja::getData();
        return view('admin.about', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutGereja::getData();
        $about->update([
            'nama_gereja' => $request->nama_gereja,
            'sejarah'     => $request->sejarah,
            'visi'        => $request->visi,
            'misi'        => $request->misi,
            'instagram'   => $request->instagram,
            'youtube'     => $request->youtube,
            'facebook'    => $request->facebook,
            'tiktok'      => $request->tiktok,
            'alamat'      => $request->alamat,
            'maps_embed'  => $request->maps_embed,
            'no_telp'     => $request->no_telp,
        ]);

        return redirect()->route('admin.about')
            ->with('success', 'Informasi gereja berhasil diupdate!');
    }
}