@extends('layouts.publik')
@section('title', 'Renungan')

@section('content')

<div class="max-w-4xl mx-auto px-5 py-16">

    {{-- Header --}}
    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Firman Tuhan</p>
        <h1 class="text-3xl font-bold text-gray-900">Renungan Harian</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    {{-- List --}}
    @if($renungan->count() > 0)
    <div class="space-y-4">
        @foreach($renungan as $r)
        <a href="{{ route('renungan.detail', $r->id) }}"
           class="group flex gap-5 bg-white border border-gray-100 rounded-2xl p-6
                  hover:border-gray-200 hover:shadow-sm transition-all">

            {{-- Tanggal --}}
            <div class="flex-shrink-0 text-center w-12">
                <p class="text-2xl font-bold text-blue-700 leading-none">
                    {{ $r->tanggal_publish->format('d') }}
                </p>
                <p class="text-[10px] uppercase text-gray-400 tracking-wide mt-1">
                    {{ $r->tanggal_publish->translatedFormat('M') }}
                </p>
                <p class="text-[10px] text-gray-300">
                    {{ $r->tanggal_publish->format('Y') }}
                </p>
            </div>

            {{-- Divider --}}
            <div class="w-px bg-gray-100 flex-shrink-0"></div>

            {{-- Konten --}}
            <div class="flex-1 min-w-0">
                @if($r->ayat)
                <p class="text-[11px] text-blue-500 font-medium mb-1.5 tracking-wide">{{ $r->ayat }}</p>
                @endif
                <h3 class="font-bold text-gray-900 text-base leading-snug mb-2
                           group-hover:text-blue-700 transition-colors">
                    {{ $r->judul }}
                </h3>
                <p class="text-xs text-gray-400 leading-relaxed line-clamp-2">
                    {{ Str::limit(strip_tags($r->isi), 160) }}
                </p>
                <div class="flex items-center justify-between mt-4">
                    <p class="text-[11px] text-gray-400">{{ $r->penulis->name }}</p>
                    <span class="flex items-center gap-1 text-[11px] font-semibold text-blue-600
                                 opacity-0 group-hover:opacity-100 transition-opacity">
                        Baca
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">{{ $renungan->links() }}</div>

    @else
    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <p class="text-sm text-gray-400">Belum ada renungan.</p>
    </div>
    @endif

</div>
@endsection