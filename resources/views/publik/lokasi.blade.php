@extends('layouts.publik')
@section('title', 'Lokasi')

@section('content')

<div class="max-w-5xl mx-auto px-5 py-16">

    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Kunjungi Kami</p>
        <h1 class="text-3xl font-bold text-gray-900">Lokasi Gereja</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Map --}}
        <div class="md:col-span-2">
            <div class="rounded-2xl overflow-hidden border border-gray-100 h-80 md:h-full min-h-[320px] bg-gray-100">
                @if($about->maps_embed ?? false)
                    {!! $about->maps_embed !!}
                @else
                <iframe
                    src="https://maps.google.com/maps?q=GPdI+Shekinah+Pangkalan+Buntu&output=embed"
                    width="100%" height="100%"
                    style="border:0; min-height:320px"
                    allowfullscreen="" loading="lazy">
                </iframe>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="space-y-4">

            <div class="bg-white border border-gray-100 rounded-2xl p-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Alamat</p>
                <div class="flex items-start gap-3">
                    <svg class="w-4 h-4 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $about->alamat ?? 'GPdI Jemaat Shekinah, Pangkalan Buntu, Kalimantan Tengah' }}
                    </p>
                </div>
            </div>

            @if($about->no_hp ?? false)
            <div class="bg-white border border-gray-100 rounded-2xl p-6">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Hubungi Kami</p>
                <a href="tel:{{ $about->no_hp }}"
                   class="flex items-center gap-3 text-sm text-gray-700 hover:text-blue-600 transition-colors">
                    <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ $about->no_hp }}
                </a>
            </div>
            @endif

            <div class="bg-blue-950 rounded-2xl p-6">
                <p class="text-xs font-semibold text-blue-400 uppercase tracking-widest mb-4">Jadwal Ibadah</p>
                <div class="space-y-2.5">
                    @foreach([
                        ['Senin','Ibadah Kaum Wanita','16.00'],
                        ['Selasa','Ibadah Kemah Pniel','19.00'],
                        ['Rabu','Ibadah Mahanaim','19.00'],
                        ['Kamis','Ibadah Filadelfia','19.00'],
                        ['Jumat','Doa Syafaat','17.00'],
                        ['Sabtu','Ibadah Pemuda','19.00'],
                        ['Minggu','Ibadah Raya','10.00'],
                    ] as [$hari,$nama,$jam])
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-blue-200">{{ $nama }}</p>
                        <p class="text-[11px] text-blue-400 font-medium">{{ $hari }}, {{ $jam }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection