<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — GPdI Shekinah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: all 0.15s ease;
        }
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

{{-- NAVBAR --}}
<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-5">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 flex-shrink-0">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}"
                         alt="GPdI Shekinah" class="h-9 w-9 object-contain">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-700 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
                <div class="leading-tight">
                    <p class="font-bold text-gray-900 text-sm">GPdI Shekinah</p>
                    <p class="text-xs text-gray-400 font-normal">Pangkalan Buntu</p>
                </div>
            </a>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center gap-0.5">
                <a href="{{ route('beranda') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ request()->routeIs('beranda') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Beranda
                </a>
                <a href="{{ route('renungan') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ request()->routeIs('renungan*') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Renungan
                </a>
                <a href="{{ route('jadwal-ibadah') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ request()->routeIs('jadwal-ibadah') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Jadwal
                </a>
                <a href="{{ route('jadwal-pelayan') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ request()->routeIs('jadwal-pelayan') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Tim Pelayan
                </a>
                <a href="{{ route('pengumuman') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ request()->routeIs('pengumuman') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Pengumuman
                </a>

                {{-- Dropdown --}}
                <div class="dropdown relative">
                    <button class="flex items-center gap-1 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                        {{ request()->routeIs('gembala','program','about','lokasi','musik','galeri') ? 'text-blue-700 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                        Lainnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu absolute top-full right-0 mt-1 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-1 overflow-hidden">
                        @foreach([
                            ['route'=>'gembala',  'label'=>'Keluarga Gembala',  'path'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                            ['route'=>'program',  'label'=>'Program Gereja',     'path'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['route'=>'musik',    'label'=>'Musik Pujian',       'path'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                            ['route'=>'galeri',   'label'=>'Galeri',             'path'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                            ['route'=>'about',    'label'=>'Tentang Gereja',     'path'=>'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['route'=>'lokasi',   'label'=>'Lokasi',             'path'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
                        ] as $item)
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['path'] }}"/>
                            </svg>
                            {{ $item['label'] }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Kanan --}}
            <div class="flex items-center gap-2">
                @auth
                <a href="{{ match(auth()->user()->role) { 'admin'=>route('admin.dashboard'), 'gembala'=>route('gembala.dashboard'), default=>route('pelayan.dashboard') } }}"
                   class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-700 border border-blue-200 hover:bg-blue-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login
                </a>
                @endauth

                <button id="hamburger"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100">
        <div class="px-4 py-4 space-y-1 bg-white">
            @foreach([
                ['route'=>'beranda',        'label'=>'Beranda',          'path'=>'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route'=>'renungan',       'label'=>'Renungan',         'path'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['route'=>'jadwal-ibadah',  'label'=>'Jadwal Ibadah',    'path'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route'=>'jadwal-pelayan', 'label'=>'Tim Pelayan',      'path'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route'=>'pengumuman',     'label'=>'Pengumuman',       'path'=>'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                ['route'=>'gembala',        'label'=>'Keluarga Gembala', 'path'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route'=>'program',        'label'=>'Program Gereja',   'path'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['route'=>'musik',          'label'=>'Musik Pujian',     'path'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                ['route'=>'galeri',         'label'=>'Galeri',           'path'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route'=>'about',          'label'=>'Tentang Gereja',   'path'=>'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['route'=>'lokasi',         'label'=>'Lokasi',           'path'=>'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
            ] as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs($item['route'].'*') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="w-4 h-4 flex-shrink-0 {{ request()->routeIs($item['route'].'*') ? 'text-blue-600' : 'text-gray-400' }}"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['path'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
            @endforeach

            <div class="pt-3 mt-2 border-t border-gray-100">
                @auth
                <a href="{{ match(auth()->user()->role) { 'admin'=>route('admin.dashboard'), 'gembala'=>route('gembala.dashboard'), default=>route('pelayan.dashboard') } }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-blue-700 hover:bg-blue-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10 0a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    Dashboard
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Login
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- KONTEN --}}
<main>
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-gray-950 text-white mt-24">
    <div class="max-w-6xl mx-auto px-5 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

            {{-- Identitas --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    @if(file_exists(public_path('images/logo-shekinah.png')))
                        <img src="{{ asset('images/logo-shekinah.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-white text-sm">GPdI Shekinah</p>
                        <p class="text-gray-400 text-xs">Pangkalan Buntu</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    Gereja Pantekosta di Indonesia Jemaat "Shekinah" — Tempat Hadirat & Kemuliaan Tuhan.
                </p>
                {{-- Sosmed --}}
                @php $about = \App\Models\AboutGereja::getData(); @endphp
                <div class="flex gap-2">
                    @if($about->instagram)
                    <a href="{{ $about->instagram }}" target="_blank"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="Instagram">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($about->youtube)
                    <a href="{{ $about->youtube }}" target="_blank"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="YouTube">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                        </svg>
                    </a>
                    @endif
                    @if($about->facebook)
                    <a href="{{ $about->facebook }}" target="_blank"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="Facebook">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    @endif
                    @if($about->tiktok)
                    <a href="{{ $about->tiktok }}" target="_blank"
                       class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors" title="TikTok">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Navigasi --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Halaman</p>
                <div class="space-y-2.5">
                    @foreach([
                        ['route'=>'beranda',       'label'=>'Beranda'],
                        ['route'=>'renungan',       'label'=>'Renungan Harian'],
                        ['route'=>'jadwal-ibadah',  'label'=>'Jadwal Ibadah'],
                        ['route'=>'jadwal-pelayan', 'label'=>'Tim Pelayan'],
                        ['route'=>'pengumuman',     'label'=>'Pengumuman'],
                        ['route'=>'galeri',         'label'=>'Galeri Foto'],
                        ['route'=>'about',          'label'=>'Tentang Gereja'],
                        ['route'=>'lokasi',         'label'=>'Lokasi'],
                    ] as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block text-sm text-gray-400 hover:text-white transition-colors">
                        {{ $link['label'] }}
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Jadwal Rutin --}}
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Jadwal Rutin</p>
                <div class="space-y-3">
                    @foreach([
                        ['hari'=>'Senin',  'nama'=>'Ibadah Kaum Wanita', 'jam'=>'16.00'],
                        ['hari'=>'Selasa', 'nama'=>'Ibadah Kemah Pniel', 'jam'=>'19.00'],
                        ['hari'=>'Rabu',   'nama'=>'Ibadah Mahanaim',    'jam'=>'19.00'],
                        ['hari'=>'Kamis',  'nama'=>'Ibadah Filadelfia',  'jam'=>'19.00'],
                        ['hari'=>'Jumat',  'nama'=>'Doa Syafaat',        'jam'=>'17.00'],
                        ['hari'=>'Sabtu',  'nama'=>'Ibadah Pemuda',      'jam'=>'19.00'],
                        ['hari'=>'Minggu', 'nama'=>'Ibadah Raya',        'jam'=>'10.00'],
                    ] as $j)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">{{ $j['nama'] }}</span>
                        <span class="text-xs text-gray-500 font-medium">{{ $j['hari'] }}, {{ $j['jam'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="border-t border-white/5 mt-14 pt-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} GPdI Jemaat "Shekinah" Pangkalan Buntu.</p>
            <p class="text-gray-600 text-xs">Dipakai untuk kemuliaan Tuhan</p>
        </div>
    </div>
</footer>

<script>
const hamburger  = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobile-menu');
const iconOpen   = document.getElementById('icon-open');
const iconClose  = document.getElementById('icon-close');
hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
    iconOpen.classList.toggle('hidden');
    iconClose.classList.toggle('hidden');
});
</script>
@stack('scripts')
</body>
</html>