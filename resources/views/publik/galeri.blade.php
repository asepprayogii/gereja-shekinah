@extends('layouts.publik')
@section('title', 'Galeri')

@section('content')

<div class="max-w-6xl mx-auto px-5 py-16">

    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Dokumentasi</p>
        <h1 class="text-3xl font-bold text-gray-900">Galeri Foto</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    @if($galeri->count() > 0)
    <div class="columns-2 md:columns-3 lg:columns-4 gap-3 space-y-3">
        @foreach($galeri as $g)
        <div class="break-inside-avoid group relative overflow-hidden rounded-xl bg-gray-100 cursor-pointer"
             onclick="openLightbox('{{ $g->foto }}','{{ $g->judul }}')">
            <img src="{{ $g->foto }}"
                 alt="{{ $g->judul }}"
                 class="w-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors duration-300
                        flex items-end p-3 opacity-0 group-hover:opacity-100">
                <p class="text-white text-xs font-medium leading-tight">{{ $g->judul }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">{{ $galeri->links() }}</div>

    @else
    <div class="bg-white rounded-2xl border border-gray-100 p-14 text-center">
        <svg class="w-8 h-8 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="text-sm text-gray-400">Belum ada foto.</p>
    </div>
    @endif

</div>

{{-- Lightbox --}}
<div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4"
     onclick="closeLightbox()">
    <button class="absolute top-5 right-5 text-white/60 hover:text-white transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <div onclick="event.stopPropagation()" class="max-w-4xl w-full">
        <img id="lightbox-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-xl">
        <p id="lightbox-caption" class="text-white/60 text-sm text-center mt-4"></p>
    </div>
</div>

<script>
function openLightbox(src, caption) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption;
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
@endsection