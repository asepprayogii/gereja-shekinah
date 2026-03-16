@extends('layouts.publik')
@section('title', 'Jadwal Ibadah')

@section('content')

<div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

    {{-- Header --}}
    <div class="mb-10 sm:mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-600 font-medium mb-2">Kegiatan Gereja</p>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Jadwal Ibadah</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    {{-- BAGIAN 1: JADWAL RUTIN - Only is_active=true --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-7 mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-gray-500 font-medium">Jadwal Rutin</p>
                <p class="text-xs text-gray-400 mt-1">Kegiatan yang berulang setiap minggu</p>
            </div>
            <div class="hidden sm:flex items-center gap-1.5 text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Setiap Pekan</span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse($rutinAktif ?? [] as $r)
            <div class="flex items-center gap-3 px-4 py-3 rounded-xl border border-transparent hover:border-gray-100 hover:bg-gray-50 transition-all card-hover">
                {{-- Badge Hari --}}
                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-50 flex flex-col items-center justify-center">
                    <span class="text-[10px] font-bold text-blue-700 uppercase leading-none">{{ substr($r->nama_hari, 0, 3) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 leading-tight">{{ $r->nama_kegiatan }}</p>
                    <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ substr($r->jam_mulai, 0, 5) }} WIB
                    </p>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-6">
                <p class="text-sm text-gray-400">Belum ada jadwal rutin yang ditampilkan.</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- BAGIAN 2: KEGIATAN KHUSUS - Only is_active=true --}}
    @php
        // Filter kegiatan yang aktif
        $publicKegiatan = $kegiatan->filter(fn($k) => $k->is_active ?? true);
        
        // Group by bulan-tahun untuk tampilan
        $grouped = $publicKegiatan->count() > 0 
            ? $publicKegiatan->groupBy(fn($k) => $k->tanggal->translatedFormat('F Y')) 
            : collect();
    @endphp

    @if($grouped->count() > 0)
        @foreach($grouped as $bulan => $items)
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-4">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">{{ $bulan }}</p>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <div class="space-y-3">
                @foreach($items as $k)
                    @php 
                        $isToday = $k->tanggal->isToday();
                        // Ambil WL dengan safe access (mencegah error jika relasi tidak loaded)
                        $wlNama = $k->jadwalWL?->nama_wl ?? ($jadwalWL[$k->id] ?? null);
                    @endphp
                    
                    <div class="group bg-white border border-gray-100 rounded-xl overflow-hidden hover:border-blue-200 hover:shadow-md transition-all duration-200 card-hover">
                        <div class="flex items-stretch">
                            
                            <div class="flex items-start gap-4 sm:gap-5 px-4 sm:px-5 py-4 flex-1 min-w-0">

                                {{-- Tanggal Badge --}}
                                <div class="flex-shrink-0 text-center w-12">
                                    <p class="text-lg sm:text-xl font-bold text-gray-900 leading-none">
                                        {{ $k->tanggal->format('d') }}
                                    </p>
                                    <p class="text-[10px] uppercase text-gray-400 tracking-wide mt-1">
                                        {{ $k->tanggal->translatedFormat('D') }}
                                    </p>
                                </div>

                                <div class="w-px h-12 bg-gray-100 flex-shrink-0 hidden sm:block"></div>

                                {{-- Info Kegiatan --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <p class="font-semibold text-gray-900 text-sm sm:text-base">
                                            {{ $k->nama_kegiatan }}
                                        </p>
                                        @if($isToday)
                                        <span class="text-[10px] font-bold bg-blue-600 text-white px-2 py-0.5 rounded-full animate-pulse">
                                            Hari Ini
                                        </span>
                                        @endif
                                        @if($k->jenis && $k->jenis != 'Ibadah')
                                        <span class="text-[10px] font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                            {{ $k->jenis }}
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mt-2">
                                        {{-- Jam --}}
                                        <span class="flex items-center gap-1.5 text-xs text-gray-500">
                                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ substr($k->jam_mulai, 0, 5) }} 
                                            @if($k->jam_selesai) - {{ substr($k->jam_selesai, 0, 5) }} @endif WIB
                                        </span>
                                        
                                        {{-- Lokasi --}}
                                        @if($k->lokasi)
                                        <span class="flex items-center gap-1.5 text-xs text-gray-600 font-medium">
                                            <svg class="w-3.5 h-3.5 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate max-w-[200px] sm:max-w-none">{{ $k->lokasi }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- 👇 WL Desktop --}}
                                @if($wlNama)
                                <div class="flex-shrink-0 text-right hidden sm:block ml-auto pl-4 border-l border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wide">WL</p>
                                    <p class="text-xs font-medium text-blue-700 mt-0.5 flex items-center justify-end gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                        </svg>
                                        {{ $wlNama }}
                                    </p>
                                </div>
                                @endif

                            </div>
                        </div>

                        {{-- 👇 WL Mobile --}}
                        @if($wlNama)
                        <div class="sm:hidden border-t border-gray-50 px-4 py-2.5 bg-blue-50/30">
                            <p class="text-[10px] text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                                </svg>
                                WL: <span class="font-medium text-blue-700">{{ $wlNama }}</span>
                            </p>
                        </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Pagination Links --}}
        <div class="mt-8">{{ $kegiatan->links() }}</div>
        
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-10 sm:p-12 text-center">
            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-500 font-medium">Tidak ada kegiatan khusus bulan ini.</p>
            <p class="text-xs text-gray-400 mt-1">Silakan cek jadwal rutin di atas untuk ibadah mingguan.</p>
        </div>
    @endif

</div>

{{-- Card hover style & utilities --}}
<style>
.card-hover { transition: all 0.2s ease; }
.card-hover:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection