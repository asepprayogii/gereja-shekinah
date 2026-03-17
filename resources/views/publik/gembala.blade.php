@extends('layouts.publik')
@section('title', 'Keluarga Gembala')

@section('content')

<style>
    .member-card { transition: transform 0.25s ease; }
    .member-card:hover { transform: translateY(-3px); }
    
    .photo-parent { width: 100px; height: 100px; }
    .photo-child { width: 65px; height: 65px; }
    
    @media (min-width: 768px) {
        .photo-parent { width: 120px; height: 120px; }
        .photo-child { width: 75px; height: 75px; }
    }
    
    @media (min-width: 1024px) {
        .photo-parent { width: 140px; height: 140px; }
        .photo-child { width: 85px; height: 85px; }
    }
    
    .ring-parent { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .ring-child { box-shadow: 0 2px 6px rgba(0,0,0,0.06); }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-16">

    {{-- HEADER --}}
    <div class="text-center mb-14">
        <p class="text-[10px] sm:text-xs uppercase tracking-[0.3em] text-blue-500 font-semibold mb-3">
            Pelayan Tuhan
        </p>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
            Keluarga Gembala
        </h1>
        <div class="w-12 h-0.5 bg-gradient-to-r from-blue-400 to-blue-600 mt-5 mx-auto rounded-full"></div>
    </div>

    @if($gembala->count() > 0)
    @php
        // === LOGIKA YANG SESUAI DENGAN ADMIN FORM ===
        // Role di database: "Gembala", "Ibu Gembala", "Anak Gembala"
        
        $gembalaPria = null;
        $gembalaWanita = null;
        $anakAnak = [];
        
        foreach($gembala as $member) {
            $peranLower = strtolower(trim($member->peran ?? ''));
            
            // Cek peran sesuai dengan yang ada di admin form
            if ($peranLower === 'gembala' || 
                str_contains($peranLower, 'gembala sidang') ||
                str_contains($peranLower, 'gembala jemaat') ||
                str_contains($peranLower, 'pendeta') ||
                str_contains($peranLower, 'pdt')) {
                // GEMBALA (PRIA)
                if (!$gembalaPria) {
                    $gembalaPria = $member;
                }
            } 
            elseif ($peranLower === 'ibu gembala' || 
                    str_contains($peranLower, 'ibu gembala') ||
                    str_contains($peranLower, 'istri gembala')) {
                // IBU GEMBALA (WANITA)
                if (!$gembalaWanita) {
                    $gembalaWanita = $member;
                }
            } 
            else {
                // ANAK-ANAK (sisanya)
                $anakAnak[] = $member;
            }
        }
    @endphp

    {{-- ROW 1: GEMBALA & IBU GEMBALA --}}
    @if($gembalaPria || $gembalaWanita)
    <div class="flex flex-col sm:flex-row items-center justify-center gap-10 sm:gap-20 mb-16">
        
        {{-- GEMBALA (KIRI) --}}
        @if($gembalaPria)
        <div class="member-card flex flex-col items-center text-center">
            <div class="photo-parent ring-parent rounded-full overflow-hidden mb-4 bg-blue-50 flex items-center justify-center border-4 border-blue-100">
                @if($gembalaPria->foto && str_starts_with($gembalaPria->foto ?? '', 'http'))
                    <img src="{{ $gembalaPria->foto }}"
                         alt="{{ $gembalaPria->nama }}"
                         class="w-full h-full object-cover"
                         loading="lazy">
                @else
                    <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1">
                {{ $gembalaPria->peran ?? 'Gembala' }}
            </span>
            <h3 class="font-bold text-gray-900 text-base">{{ $gembalaPria->nama }}</h3>
            @if($gembalaPria->bio)
            <p class="text-[11px] text-gray-500 mt-1.5 max-w-[160px] leading-relaxed">
                {{ Str::limit($gembalaPria->bio, 60) }}
            </p>
            @endif
        </div>
        @endif

        {{-- IBU GEMBALA (KANAN) --}}
        @if($gembalaWanita)
        <div class="member-card flex flex-col items-center text-center">
            <div class="photo-parent ring-parent rounded-full overflow-hidden mb-4 bg-pink-50 flex items-center justify-center border-4 border-pink-100">
                @if($gembalaWanita->foto && str_starts_with($gembalaWanita->foto ?? '', 'http'))
                    <img src="{{ $gembalaWanita->foto }}"
                         alt="{{ $gembalaWanita->nama }}"
                         class="w-full h-full object-cover"
                         loading="lazy">
                @else
                    <svg class="w-10 h-10 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-pink-600 mb-1">
                {{ $gembalaWanita->peran ?? 'Ibu Gembala' }}
            </span>
            <h3 class="font-bold text-gray-900 text-base">{{ $gembalaWanita->nama }}</h3>
            @if($gembalaWanita->bio)
            <p class="text-[11px] text-gray-500 mt-1.5 max-w-[160px] leading-relaxed">
                {{ Str::limit($gembalaWanita->bio, 60) }}
            </p>
            @endif
        </div>
        @endif

    </div>

    {{-- DIVIDER --}}
    @if(count($anakAnak) > 0)
    <div class="flex items-center justify-center gap-3 mb-10">
        <div class="w-12 h-px bg-gradient-to-r from-transparent to-gray-200"></div>
        <svg class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <div class="w-12 h-px bg-gradient-to-l from-transparent to-gray-200"></div>
    </div>
    @endif
    @endif

    {{-- ROW 2: ANAK-ANAK --}}
    @if(count($anakAnak) > 0)
    <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
        @foreach($anakAnak as $anak)
        <div class="member-card flex flex-col items-center text-center w-20 sm:w-24">
            <div class="photo-child ring-child rounded-full overflow-hidden mb-3 bg-gray-50 flex items-center justify-center border-2 border-gray-100">
                @if($anak->foto && str_starts_with($anak->foto ?? '', 'http'))
                    <img src="{{ $anak->foto }}"
                         alt="{{ $anak->nama }}"
                         class="w-full h-full object-cover"
                         loading="lazy">
                @else
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>
            @if($anak->peran)
            <span class="text-[9px] font-medium uppercase tracking-wide text-gray-400 mb-0.5">
                {{ $anak->peran }}
            </span>
            @endif
            <h4 class="font-semibold text-gray-800 text-xs sm:text-sm leading-tight">
                {{ $anak->nama }}
            </h4>
        </div>
        @endforeach
    </div>
    @endif

    @else
    {{-- EMPTY STATE --}}
    <div class="text-center py-16">
        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-50 flex items-center justify-center">
            <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <p class="text-sm text-gray-500">Belum ada data keluarga gembala.</p>
    </div>
    @endif

</div>

@endsection