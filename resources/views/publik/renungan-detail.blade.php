@extends('layouts.publik')
@section('title', $renungan->judul)

@section('content')

<div class="max-w-2xl mx-auto px-5 py-16">

    {{-- Back --}}
    <a href="{{ route('renungan') }}"
       class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-700
              transition-colors mb-10">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Renungan
    </a>

    {{-- Meta --}}
    <div class="mb-8">
        <div class="flex items-center gap-2 mb-4">
            <p class="text-xs text-blue-500 font-medium tracking-wide">
                {{ $renungan->tanggal_publish->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-5">
            {{ $renungan->judul }}
        </h1>
        @if($renungan->ayat)
        <div class="bg-blue-50 border-l-4 border-blue-400 rounded-r-xl px-5 py-4 mb-6">
            <p class="text-sm text-blue-700 italic leading-relaxed font-medium">
                {{ $renungan->ayat }}
            </p>
        </div>
        @endif
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <p class="text-xs text-gray-500">{{ $renungan->penulis->name }}</p>
        </div>
    </div>

    {{-- Divider --}}
    <div class="border-t border-gray-100 mb-8"></div>

    {{-- Isi --}}
    <div class="prose prose-sm prose-gray max-w-none
                prose-p:leading-relaxed prose-p:text-gray-600
                prose-headings:text-gray-900 prose-headings:font-bold">
        {!! nl2br(e($renungan->isi)) !!}
    </div>

    {{-- Footer --}}
    <div class="border-t border-gray-100 mt-12 pt-6 flex items-center justify-between">
        <a href="{{ route('renungan') }}"
           class="flex items-center gap-1.5 text-xs font-medium text-gray-500 hover:text-gray-800 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Renungan lainnya
        </a>
    </div>

</div>
@endsection