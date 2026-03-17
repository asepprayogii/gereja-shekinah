<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlideshow;
use Illuminate\Http\Request;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class SlideshowController extends Controller
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
        $slideshow = HeroSlideshow::orderBy('urutan')->get();
        return view('admin.slideshow', compact('slideshow'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $cloudinary = $this->getCloudinary();
        $result = $cloudinary->uploadApi()->upload(
            $request->file('foto')->getRealPath(),
            ['folder' => 'gereja-shekinah/slideshow']
        );

        HeroSlideshow::create([
            'foto'            => $result['secure_url'],
            'urutan'          => HeroSlideshow::count() + 1,
            'object_position' => $request->object_position ?? 'center',
            'is_active'       => $request->has('is_active'),
        ]);

        return redirect()->route('admin.slideshow')
            ->with('success', 'Foto slideshow berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $slide = HeroSlideshow::findOrFail($id);

        if (str_starts_with($slide->foto, 'http')) {
            $path = parse_url($slide->foto, PHP_URL_PATH);
            preg_match('/upload\/(?:v\d+\/)?(.+)\.\w+$/', $path, $matches);
            if (!empty($matches[1])) {
                $cloudinary = $this->getCloudinary();
                $cloudinary->uploadApi()->destroy($matches[1]);
            }
        }

        $slide->delete();

        HeroSlideshow::orderBy('urutan')->get()->each(function ($s, $i) {
            $s->update(['urutan' => $i + 1]);
        });

        return redirect()->route('admin.slideshow')
            ->with('success', 'Foto berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $slide = HeroSlideshow::findOrFail($id);
        $slide->update(['is_active' => !$slide->is_active]);

        return redirect()->route('admin.slideshow')
            ->with('success', 'Status foto berhasil diubah!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order'   => 'required|array',
            'order.*' => 'integer|exists:hero_slideshow,id',
        ]);

        foreach ($request->order as $index => $id) {
            HeroSlideshow::where('id', $id)->update(['urutan' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
