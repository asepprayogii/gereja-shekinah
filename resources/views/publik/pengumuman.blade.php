@extends('layouts.publik')
@section('title', 'Pengumuman')

@section('content')

<div class="max-w-4xl mx-auto px-5 py-16">

    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Informasi</p>
        <h1 class="text-3xl font-bold text-gray-900">Pengumuman</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    @if($pengumuman->count() > 0)
    <div class="space-y-3">
        @foreach($pengumuman as $p)
        <a href="{{ route('pengumuman.detail', $p->id) }}"
           class="bg-white border border-gray-100 rounded-2xl p-6 hover:border-blue-200 hover:shadow-sm transition-all group flex items-start justify-between gap-4 block">
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-400 mb-2 tracking-wide">
                    {{ $p->tanggal_publish->translatedFormat('l, d F Y') }}
                </p>
                <h3 class="font-bold text-gray-900 text-base leading-snug mb-3 group-hover:text-blue-700 transition-colors">
                    {{ $p->judul }}
                </h3>
                <p class="text-sm text-gray-500 leading-relaxed">
                    {{ Str::limit(strip_tags($p->isi), 200) }}
                </p>
            </div>
            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0
                        group-hover:bg-blue-600 transition-colors mt-1">
                <svg class="w-3.5 h-3.5 text-gray-300 group-hover:text-white transition-colors"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        @endforeach
    </div>
    <div class="mt-8">{{ $pengumuman->links() }}</div>

    @else
    <div class="bg-white rounded-2xl border border-gray-100 p-14 text-center">
        <svg class="w-8 h-8 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
        </svg>
        <p class="text-sm text-gray-400">Belum ada pengumuman.</p>
    </div>
    @endif

</div>
@endsection