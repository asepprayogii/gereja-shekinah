@extends('layouts.publik')
@section('title', $pengumuman->judul)

@section('content')
<div class="max-w-3xl mx-auto px-5 py-24">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 mb-8 text-xs text-gray-400">
        <a href="{{ route('beranda') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('pengumuman') }}" class="hover:text-blue-600 transition-colors">Pengumuman</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-600 truncate max-w-[200px]">{{ $pengumuman->judul }}</span>
    </div>

    {{-- Card konten --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-8 md:p-12">

        <div class="flex items-center gap-2 mb-6">
            <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <span class="text-xs font-semibold text-blue-600 uppercase tracking-widest">Pengumuman</span>
        </div>

        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-snug mb-3">
            {{ $pengumuman->judul }}
        </h1>

        <p class="text-xs text-gray-400 mb-8 pb-8 border-b border-gray-100">
            {{ $pengumuman->tanggal_publish->translatedFormat('l, d F Y') }}
        </p>

        <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
            {{ $pengumuman->isi }}
        </div>

    </div>

    {{-- Tombol kembali --}}
    <div class="mt-8">
        <a href="{{ route('pengumuman') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Pengumuman
        </a>
    </div>

</div>
@endsection