@extends('layouts.publik')
@section('title', 'Program Gereja')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">

    <div class="text-center mb-10">
        <p class="text-sm uppercase tracking-widest text-blue-500 mb-2">Kegiatan Kami</p>
        <h1 class="text-3xl font-bold text-blue-800">Program Gereja</h1>
        <div class="w-16 h-1 bg-blue-300 rounded-full mx-auto mt-3"></div>
    </div>

    @if($program->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($program as $p)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
            @if($p->foto)
            <img src="{{ $p->foto }}"
                 alt="{{ $p->nama_program }}"
                 class="w-full h-48 object-cover">
            @else
            <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                <span class="text-6xl">🏫</span>
            </div>
            @endif
            <div class="p-6">
                <h3 class="font-bold text-gray-800 text-xl">{{ $p->nama_program }}</h3>
                @if($p->deskripsi)
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">{{ $p->deskripsi }}</p>
                @endif
                @if($p->link_info)
                <a href="{{ $p->link_info }}" target="_blank"
                   class="inline-block mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Info Lebih Lanjut →
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-16">
        <p class="text-6xl mb-4">🏫</p>
        <p class="text-gray-400">Informasi program gereja belum tersedia.</p>
    </div>
    @endif

</div>
@endsection