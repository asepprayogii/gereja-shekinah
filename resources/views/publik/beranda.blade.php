@extends('layouts.publik')
@section('title', 'Beranda')

@section('content')

<style>
html { scroll-behavior: smooth; }

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeUp 0.7s ease forwards; }
.fade-up-1 { animation-delay: 0.1s; opacity: 0; }
.fade-up-2 { animation-delay: 0.25s; opacity: 0; }
.fade-up-3 { animation-delay: 0.4s; opacity: 0; }
.fade-up-4 { animation-delay: 0.6s; opacity: 0; }

/* Roster Styles - Mobile First */
.roster-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    min-width: 100%;
}
@media (max-width: 768px) {
    .roster-grid {
        grid-template-columns: repeat(7, 140px);
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .roster-grid::-webkit-scrollbar { display: none; }
    .roster-col { scroll-snap-align: start; }
}
.roster-col:first-child { border-left: none; }
.today-col { background: #eff6ff; }
.today-col .day-label { color: #1d4ed8; font-weight: 700; }

section[id] { scroll-margin-top: 100px; }

/* Smooth hover for cards */
.card-hover { transition: all 0.2s ease; }
.card-hover:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
</style>

{{-- ═══════════════════════════════════════════ --}}
{{-- HERO --}}
{{-- ═══════════════════════════════════════════ --}}
<div class="relative w-full h-screen overflow-hidden bg-blue-950">

    @foreach($slideshow as $i => $slide)
    <div class="slide absolute inset-0 transition-opacity duration-1000"
         style="opacity:{{ $i===0?'1':'0' }}">
        <img src="{{ $slide->foto }}"
             alt="GPdI Shekinah"
             class="w-full h-full object-cover opacity-50">
    </div>
    @endforeach

    <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-black/75"></div>
    <div class="absolute inset-0 bg-black/25"></div>

    <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-6 z-10">

        <div class="fade-up fade-up-1 flex items-center gap-3 mb-6">
            <div class="w-8 h-px bg-white/50"></div>
            <p class="text-[11px] tracking-[0.3em] text-white/70 font-medium">
                Gereja Pantekosta di Indonesia
            </p>
            <div class="w-8 h-px bg-white/50"></div>
        </div>

        <h1 class="fade-up fade-up-2 text-4xl md:text-7xl font-bold tracking-tight leading-none mb-3 drop-shadow-lg">
            GPdI Jemaat<br>
            <span class="text-blue-300">"Shekinah"</span>
        </h1>

        <p class="fade-up fade-up-3 text-white/70 text-sm md:text-base font-light tracking-widest mt-4 drop-shadow">
            Pangkalan Buntu
        </p>

        <div class="fade-up fade-up-3 flex items-center gap-3 mt-5 mb-10">
            <div class="w-16 h-px bg-white/25"></div>
            <p class="text-white/50 text-xs tracking-widest uppercase">Tempat Hadirat & Kemuliaan Tuhan</p>
            <div class="w-16 h-px bg-white/25"></div>
        </div>

        <div class="fade-up fade-up-4 flex flex-col sm:flex-row items-center gap-3">
            <a href="#jadwal-ibadah-section"
               class="flex items-center gap-2 bg-white text-blue-900 font-semibold text-sm
                      px-6 py-3 rounded-full hover:bg-blue-50 transition-colors shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal Ibadah
            </a>
            <a href="#renungan-section"
               class="flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white font-semibold text-sm
                      px-6 py-3 rounded-full border border-white/30 hover:bg-white/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Renungan
            </a>
        </div>
    </div>

    @if($slideshow->count() > 1)
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
        @foreach($slideshow as $i => $s)
        <div class="dot h-1 rounded-full transition-all duration-500
                    {{ $i===0 ? 'w-6 bg-white' : 'w-1.5 bg-white/30' }}"></div>
        @endforeach
    </div>
    @endif

    <div class="absolute bottom-10 right-8 z-10 flex flex-col items-center gap-1.5">
        <div class="w-px h-10 bg-white/30 animate-pulse"></div>
        <p class="text-white/40 text-[10px] tracking-widest uppercase" style="writing-mode:vertical-rl">Scroll</p>
    </div>
</div>

@if($slideshow->count() > 1)
<script>
const slides=document.querySelectorAll('.slide'),dots=document.querySelectorAll('.dot');
let cur=0;
function goTo(n){
    slides.forEach(s=>s.style.opacity='0');
    dots.forEach(d=>{d.classList.remove('w-6','bg-white');d.classList.add('w-1.5','bg-white/30');});
    slides[n].style.opacity='1';
    dots[n].classList.remove('w-1.5','bg-white/30');
    dots[n].classList.add('w-6','bg-white');
    cur=n;
}
setInterval(()=>goTo((cur+1)%slides.length),4500);
</script>
@endif

{{-- ═══════════════════════════════════════════ --}}
{{-- RENUNGAN + ULTAH --}}
{{-- ═══════════════════════════════════════════ --}}
<section id="renungan-section" class="max-w-6xl mx-auto px-5 py-20">
    <div class="{{ $ultah->count() > 0 ? 'grid grid-cols-1 md:grid-cols-3 gap-5' : 'grid grid-cols-1 gap-5' }}">

        {{-- RENUNGAN --}}
        <div class="{{ $ultah->count() > 0 ? 'md:col-span-2' : '' }}">
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Renungan Hari Ini</h2>
            </div>

            @if($renungan)
            <div class="bg-white rounded-2xl border border-gray-100 p-7 h-full card-hover">
                <p class="text-xs text-gray-400 tracking-wide mb-4">
                    {{ $renungan->tanggal_publish->translatedFormat('l, d F Y') }}
                </p>
                <h3 class="text-2xl font-bold text-gray-900 leading-snug mb-4">
                    {{ $renungan->judul }}
                </h3>
                @if($renungan->ayat)
                <div class="border-l-2 border-blue-200 pl-4 mb-5">
                    <p class="text-sm text-blue-600 italic leading-relaxed">{{ $renungan->ayat }}</p>
                </div>
                @endif
                <p class="text-sm text-gray-500 leading-relaxed">
                    {{ Str::limit(strip_tags($renungan->isi), 300) }}
                </p>
                <div class="flex items-center justify-between mt-6 pt-5 border-t border-gray-50">
                    <p class="text-xs text-gray-400">{{ $renungan->penulis->name }}</p>
                    <a href="{{ route('renungan.detail', $renungan->id) }}"
                       class="flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                        Baca selengkapnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center h-full flex flex-col items-center justify-center">
                <svg class="w-10 h-10 text-gray-150 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="text-sm text-gray-400">Belum ada renungan hari ini.</p>
            </div>
            @endif
        </div>

        {{-- ULANG TAHUN --}}
        @if($ultah->count() > 0)
        <div>
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-pink-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.752 1.752 0 013 15.546V12a9 9 0 0118 0v3.546zM12 6V3m-3 3l1.5-2.5M15 6l-1.5-2.5"/>
                </svg>
                <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Ulang Tahun</h2>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="space-y-3">
                    @foreach($ultah as $j)
                    <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0">
                        <div class="w-8 h-8 rounded-full bg-pink-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800 leading-tight">{{ $j->nama_lengkap }}</p>
                            <p class="text-xs text-pink-400 mt-0.5">{{ $j->tanggal_lahir->translatedFormat('d F') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- ROSTER JADWAL MINGGUAN - FILTERED BY is_active --}}
{{-- ═══════════════════════════════════════════ --}}
<section id="jadwal-ibadah-section" style="background:#f7f8fa" class="py-20 border-y border-gray-100">
    <div class="max-w-6xl mx-auto px-5">

        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Jadwal Ibadah</h2>
                </div>
                <p class="text-xs text-gray-400 ml-6">
                    Minggu ini · {{ \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->translatedFormat('d') }} 
                    – {{ \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('jadwal-ibadah') }}"
               class="flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                Lihat semua
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @php
        // FIXED: Only show activities where is_active = true (from admin toggle)
        $publicKegiatan = $kegiatan->filter(fn($k) => $k->is_active ?? true);
        
        $hariList = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $startOfWeek = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
        $todayDow = (\Carbon\Carbon::now()->dayOfWeekIso - 1);

        // Group by day (0=Senin to 6=Minggu)
        $kegiatanByHari = [];
        foreach($publicKegiatan as $k) {
            $dow = ($k->tanggal->dayOfWeekIso - 1);
            $kegiatanByHari[$dow][] = $k;
        }
        @endphp

        {{-- Roster - Mobile: horizontal scroll, Desktop: full width --}}
        <div class="overflow-x-auto -mx-5 px-5 scrollbar-hide">
            <div class="roster-grid rounded-2xl overflow-hidden border border-gray-200 bg-white">

                @for($dow = 0; $dow < 7; $dow++)
                @php
                    $tanggal = $startOfWeek->copy()->addDays($dow);
                    $isToday = ($dow === $todayDow);
                    $items   = $kegiatanByHari[$dow] ?? [];
                @endphp

                <div class="roster-col border-l border-gray-100 {{ $isToday ? 'bg-blue-50' : '' }} flex flex-col min-h-[280px]">

                    {{-- Header --}}
                    <div class="px-3 py-3 border-b {{ $isToday ? 'border-blue-100 bg-blue-600' : 'border-gray-100 bg-gray-50' }} text-center">
                        <p class="text-[11px] font-semibold uppercase tracking-wider {{ $isToday ? 'text-white' : 'text-gray-500' }}">
                            {{ $hariList[$dow] }}
                        </p>
                        <p class="text-lg font-bold mt-0.5 {{ $isToday ? 'text-white' : 'text-gray-800' }}">
                            {{ $tanggal->format('d') }}
                        </p>
                        @if($isToday)
                        <div class="w-1 h-1 rounded-full bg-white/60 mx-auto mt-1"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-2 flex flex-col gap-1.5 flex-1">
                        @if(count($items) > 0)
                            @foreach($items as $k)
                            <div class="rounded-lg px-2.5 py-2 text-left card-hover"
                                 style="background-color: {{ $k->warna ?? '#3b82f6' }}18; border-left: 2px solid {{ $k->warna ?? '#3b82f6' }}">
                                <p class="text-[11px] font-semibold leading-tight text-gray-800">
                                    {{ $k->nama_kegiatan }}
                                </p>
                                <p class="text-[10px] mt-1 font-medium" style="color: {{ $k->warna ?? '#3b82f6' }}">
                                    {{ substr($k->jam_mulai, 0, 5) }}
                                </p>
                                @if($k->lokasi)
                                <p class="text-[10px] text-gray-400 mt-0.5 truncate">
                                    {{ $k->lokasi }}
                                </p>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <div class="flex-1 flex items-center justify-center">
                                <p class="text-[10px] text-gray-300 text-center">—</p>
                            </div>
                        @endif
                    </div>

                </div>
                @endfor

            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-4 md:hidden">Geser ke kanan untuk melihat semua hari</p>

    </div>
</section>

{{-- ═══════════════════════════════════════════ --}}
{{-- PENGUMUMAN --}}
{{-- ═══════════════════════════════════════════ --}}
<section class="max-w-6xl mx-auto px-5 py-20">

    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <h2 class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Pengumuman Terbaru</h2>
        </div>
        <a href="{{ route('pengumuman') }}"
           class="flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
            Lihat semua
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @if($pengumuman->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($pengumuman as $p)
            <a href="{{ route('pengumuman.detail', $p->id) }}"
            class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-blue-200 hover:shadow-sm transition-all group block card-hover">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs text-gray-400 tracking-wide">
                        {{ $p->tanggal_publish->translatedFormat('d F Y') }}
                    </span>
                    <div class="w-6 h-6 rounded-full bg-blue-50 flex items-center justify-center
                                group-hover:bg-blue-600 transition-colors">
                        <svg class="w-3 h-3 text-blue-400 group-hover:text-white transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm leading-snug mb-3">{{ $p->judul }}</h3>
                <p class="text-xs text-gray-400 leading-relaxed">
                    {{ Str::limit(strip_tags($p->isi), 110) }}
                </p>
            </a>
            @endforeach
    </div>
    @else
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <svg class="w-8 h-8 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
        </svg>
        <p class="text-sm text-gray-400">Belum ada pengumuman terbaru.</p>
    </div>
    @endif

</section>

{{-- Scroll Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth anchor scroll with navbar offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if(targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if(targetElement) {
                e.preventDefault();
                const navbarHeight = document.getElementById('navbar-publik')?.offsetHeight || 80;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                history.pushState(null, null, targetId);
            }
        });
    });
    
    // Handle direct hash navigation
    if(window.location.hash) {
        setTimeout(() => {
            const targetElement = document.querySelector(window.location.hash);
            if(targetElement) {
                const navbarHeight = document.getElementById('navbar-publik')?.offsetHeight || 80;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight - 20;
                window.scrollTo({ top: targetPosition, behavior: 'auto' });
            }
        }, 100);
    }
});
</script>

@endsection