<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Admin GPdI Shekinah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        #sidebar { transition: all 0.3s ease; }
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }

        .sidebar-collapsed { width: 4.5rem !important; }
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-label,
        .sidebar-collapsed .sidebar-divider,
        .sidebar-collapsed .user-info-text,
        .sidebar-collapsed .user-actions-text { display: none; }
        .sidebar-collapsed .logo-full { display: none; }
        .sidebar-collapsed .logo-icon { display: flex !important; }
        .sidebar-collapsed .menu-item { justify-content: center; padding-left: 0.75rem; padding-right: 0.75rem; }
        .sidebar-collapsed .section-title { display: none; }
        .sidebar-collapsed #sidebar-collapse svg { transform: scaleX(-1); }
        .sidebar-collapsed .badge-notification { display: none; }
    </style>
</head>
{{-- h-screen + overflow-hidden di body agar scroll ada di #main-content, bukan body --}}
<body class="bg-gray-50 text-gray-900 antialiased h-screen overflow-hidden">

<div class="flex h-full">

    {{-- SIDEBAR --}}
    <aside id="sidebar"
           class="w-64 bg-blue-800 border-r border-blue-700 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 overflow-y-auto">

        {{-- Logo + Collapse Toggle --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-blue-700 flex-shrink-0">
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 flex-shrink-0 logo-full">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}" alt="GPdI Shekinah" class="h-9 w-9 object-contain">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
                <div class="leading-tight">
                    <p class="font-bold text-white text-sm">GPdI Shekinah</p>
                    <p class="text-xs text-blue-200 font-normal">Panel Admin</p>
                </div>
            </a>
            <a href="{{ route('beranda') }}" class="hidden logo-icon flex-shrink-0">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}" alt="GPdI Shekinah" class="h-9 w-9 object-contain">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
            </a>
            <button id="sidebar-collapse" class="p-1.5 rounded-lg text-blue-200 hover:bg-blue-700 transition-colors hidden md:flex">
                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Menu Navigation --}}
        <nav class="flex-1 px-2 py-4 space-y-0.5 overflow-y-auto">

            <a href="{{ route('admin.dashboard') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('admin.dashboard') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text sidebar-label">Dashboard</span>
            </a>

            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Jemaat</p>
            <a href="{{ route('admin.jemaat') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('admin.jemaat*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="sidebar-text sidebar-label">Data Jemaat</span>
            </a>
            <a href="{{ route('admin.pengguna') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('admin.pengguna*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="sidebar-text sidebar-label">Kelola Akun</span>
            </a>

            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Konten</p>
            @php
            $menuKonten = [
                ['route'=>'admin.renungan',   'label'=>'Renungan',      'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
                ['route'=>'admin.pengumuman', 'label'=>'Pengumuman',    'icon'=>'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                ['route'=>'admin.musik',      'label'=>'Musik Pujian',  'icon'=>'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                ['route'=>'admin.galeri',     'label'=>'Galeri',        'icon'=>'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route'=>'admin.slideshow',  'label'=>'Slideshow',     'icon'=>'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
            ];
            @endphp
            @foreach($menuKonten as $item)
            <a href="{{ route($item['route']) }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs($item['route'].'*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                </svg>
                <span class="sidebar-text sidebar-label">{{ $item['label'] }}</span>
            </a>
            @endforeach

            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Jadwal</p>
            @php
            $menuJadwal = [
                ['route'=>'admin.kalender',             'label'=>'Kalender Kegiatan',   'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'badge'=>null],
                ['route'=>'admin.jadwal-ibadah-minggu', 'label'=>'Jadwal Pelayan Minggu',       'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'badge'=>null],
                ['route'=>'admin.jadwal-wl',            'label'=>'Jadwal WL',           'icon'=>'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z', 'badge'=>null],
                ['route'=>'admin.tukar-jadwal',         'label'=>'Tukar Jadwal',        'icon'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'badge'=>\App\Models\TukarJadwal::where('status','menunggu')->count()],
            ];
            @endphp
            @foreach($menuJadwal as $item)
            <a href="{{ route($item['route']) }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs($item['route'].'*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                </svg>
                <span class="sidebar-text sidebar-label flex-1">{{ $item['label'] }}</span>
                @if(!empty($item['badge']) && $item['badge'] > 0)
                <span class="sidebar-text badge-notification bg-orange-500 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded-full flex-shrink-0">
                    {{ $item['badge'] }}
                </span>
                @endif
            </a>
            @endforeach

            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Gereja</p>
            @php
            $menuGereja = [
                ['route'=>'admin.gembala', 'label'=>'Keluarga Gembala', 'icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route'=>'admin.program', 'label'=>'Program Gereja',   'icon'=>'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['route'=>'admin.about',   'label'=>'About & Sosmed',   'icon'=>'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
            @endphp
            @foreach($menuGereja as $item)
            <a href="{{ route($item['route']) }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs($item['route'].'*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                </svg>
                <span class="sidebar-text sidebar-label">{{ $item['label'] }}</span>
            </a>
            @endforeach

        </nav>

        {{-- User Info + Logout --}}
        <div class="border-t border-blue-700 px-3 py-3 flex-shrink-0">
            <div class="flex items-center gap-3 mb-3">
                @if(auth()->user()->foto && str_starts_with(auth()->user()->foto, 'http'))
                    <img src="{{ auth()->user()->foto }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-8 h-8 rounded-full object-cover flex-shrink-0 ring-2 ring-blue-600">
                @else
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0 ring-2 ring-blue-600">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0 user-info-text">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-200 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full text-xs font-medium text-blue-100 hover:text-white bg-blue-700 hover:bg-blue-600 border border-blue-600 rounded-lg py-1.5 transition-colors flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="user-actions-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- OVERLAY Mobile --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    {{-- KONTEN UTAMA — overflow-y-auto di sini agar topbar tidak ikut scroll --}}
    <div class="flex-1 flex flex-col md:ml-64 min-w-0 h-full overflow-y-auto overflow-x-hidden" id="main-content">

        {{-- Topbar — sticky di dalam main-content --}}
        <header class="bg-white border-b border-gray-100 px-4 md:px-6 py-3 flex items-center justify-between sticky top-0 z-30 flex-shrink-0">
            <div class="flex items-center gap-3 min-w-0">
                <button id="sidebar-toggle"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors flex-shrink-0">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <h1 class="font-bold text-gray-900 text-base truncate">@yield('title')</h1>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('beranda') }}" target="_blank"
                   class="flex items-center gap-1.5 text-xs font-medium text-gray-600 hover:text-blue-700 border border-gray-200 rounded-lg px-2.5 py-1.5 hover:bg-gray-50 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                    <span class="hidden sm:inline">Website</span>
                </a>
                <div class="text-xs text-gray-400 hidden sm:block">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
        <div class="px-4 md:px-6 pt-4">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-2 text-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 ml-4 flex-shrink-0">✕</button>
            </div>
            @endif
            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-2 text-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 ml-4 flex-shrink-0">✕</button>
            </div>
            @endif
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 px-4 md:px-6 py-5">
            @yield('content')
        </main>

    </div>
</div>

<script>
    const sidebarToggle   = document.getElementById('sidebar-toggle');
    const sidebarCollapse = document.getElementById('sidebar-collapse');
    const sidebar         = document.getElementById('sidebar');
    const overlay         = document.getElementById('sidebar-overlay');
    const iconOpen        = document.getElementById('icon-open');
    const iconClose       = document.getElementById('icon-close');
    const mainContent     = document.getElementById('main-content');

    let isCollapsed = false;

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        iconOpen.classList.add('hidden');
        iconClose.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        iconOpen.classList.remove('hidden');
        iconClose.classList.add('hidden');
    }

    function toggleCollapse() {
        isCollapsed = !isCollapsed;
        if (isCollapsed) {
            sidebar.classList.add('sidebar-collapsed');
            mainContent.classList.replace('md:ml-64', 'md:ml-[4.5rem]');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.replace('md:ml-[4.5rem]', 'md:ml-64');
        }
    }

    sidebarToggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
    sidebarCollapse?.addEventListener('click', toggleCollapse);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });
</script>

@stack('scripts')
</body>
</html>