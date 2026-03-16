<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Musik;
use Illuminate\Http\Request;

class MusikController extends Controller
{
    public function index(Request $request)
    {
        $query = Musik::orderBy('urutan');

        if ($request->search) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul_lagu', 'like', "%$q%")
                   ->orWhere('penyanyi', 'like', "%$q%");
            });
        }

        $musik = $query->get();
        return view('admin.musik', compact('musik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lagu'   => 'required|string|max:255',
            'link_youtube' => 'required|url',
        ]);

        $videoId = Musik::ekstrakVideoId($request->link_youtube);

        Musik::create([
            'judul_lagu'    => $request->judul_lagu,
            'penyanyi'      => $request->penyanyi,
            'link_youtube'  => $request->link_youtube,
            'video_id'      => $videoId,
            'thumbnail_url' => $videoId
                ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
                : null,
            'urutan'        => Musik::count() + 1,
        ]);

        return redirect()->route('admin.musik')
            ->with('success', 'Lagu berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Musik::findOrFail($id)->delete();
        return redirect()->route('admin.musik')
            ->with('success', 'Lagu berhasil dihapus!');
    }
}