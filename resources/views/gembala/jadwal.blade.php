@extends('layouts.gembala')
@section('title', 'Jadwal Minggu Ini')

@section('content')

{{-- Judul dengan dekorasi --}}
<div class="flex items-center gap-3 mb-6">
    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
    </div>
    <div>
        <h1 class="text-xl font-bold text-gray-800">Jadwal Minggu Ini</h1>
        <p class="text-xs text-gray-500 mt-0.5">{{ now()->startOfWeek()->translatedFormat('d M') }} - {{ now()->endOfWeek()->translatedFormat('d M Y') }}</p>
    </div>
</div>

{{-- Daftar Kegiatan --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    
    @if(isset($kegiatan) && $kegiatan->count() > 0)
        
        {{-- Group by day of week (Senin = 1, Minggu = 7) --}}
        @php
            $daysOfWeek = [1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 7 => 'Minggu'];
            $groupedByDay = [];
            
            foreach ($kegiatan as $item) {
                $dayNumber = $item->tanggal->dayOfWeekIso; // 1 (Senin) - 7 (Minggu)
                $groupedByDay[$dayNumber][] = $item;
            }
            
            // Urutkan dari Senin (1) ke Minggu (7)
            ksort($groupedByDay);
        @endphp
        
        {{-- Loop each day --}}
        @foreach($groupedByDay as $dayNumber => $items)
            <div class="border-b border-gray-100 last:border-b-0">
                {{-- Day Header --}}
                <div class="bg-gradient-to-r from-indigo-50 to-white px-5 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                        <h3 class="font-semibold text-gray-700 text-sm">{{ $daysOfWeek[$dayNumber] }}</h3>
                    </div>
                    <span class="text-xs text-gray-400">{{ $items[0]->tanggal->format('d M Y') }}</span>
                </div>
                
                {{-- Activities for this day --}}
                <div class="divide-y divide-gray-50">
                    @foreach($items as $k)
                    <div class="p-4 hover:bg-indigo-50/30 transition group">
                        <div class="flex items-start gap-4">
                            {{-- Time Badge --}}
                            <div class="w-16 flex-shrink-0">
                                <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg">
                                    {{ substr($k->jam_mulai, 0, 5) }}
                                </span>
                            </div>
                            
                            {{-- Content --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="font-medium text-gray-800">{{ $k->nama_kegiatan }}</p>
                                    @if($k->tanggal->isToday())
                                    <span class="text-[10px] bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-medium">Hari Ini</span>
                                    @endif
                                </div>
                                
                                @if($k->lokasi)
                                <p class="text-xs text-gray-500 mt-1.5 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $k->lokasi }}
                                </p>
                                @endif
                            </div>
                            
                            {{-- Arrow indicator --}}
                            <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-400 transition opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        
    @else
        {{-- Empty State --}}
        <div class="text-center py-12 px-4">
            <div class="w-16 h-16 mx-auto bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada kegiatan minggu ini</p>
            <p class="text-xs text-gray-400 mt-1">Silakan cek kembali minggu depan</p>
        </div>
    @endif
</div>

{{-- Footer kecil --}}
<div class="mt-4 text-center">
    <p class="text-[10px] text-gray-400">✨ Tetap semangat melayani ✨</p>
</div>

<style>
/* Animasi hover */
.group:hover .group-hover\:opacity-100 {
    transition: opacity 0.2s ease;
}
</style>

@endsection