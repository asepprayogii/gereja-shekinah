<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Gembala GPdI Shekinah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Smooth transition untuk sidebar */
        #sidebar { transition: all 0.3s ease; }

        /* Custom scrollbar untuk sidebar */
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 4px; }

        /* === STYLE UNTUK SIDEBAR COLLAPSED === */
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
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

<div class="flex min-h-screen">

    {{-- SIDEBAR — Blue theme with collapse feature --}}
    <aside id="sidebar"
           class="w-64 bg-blue-800 border-r border-blue-700 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full md:translate-x-0 overflow-y-auto">

        {{-- Logo + Collapse Toggle --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-blue-700">
            {{-- Logo Full --}}
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 flex-shrink-0 logo-full">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}"
                         alt="GPdI Shekinah" class="h-9 w-9 object-contain">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
                <div class="leading-tight">
                    <p class="font-bold text-white text-sm">GPdI Shekinah</p>
                    <p class="text-xs text-blue-200 font-normal">Panel Gembala</p>
                </div>
            </a>

            {{-- Logo Icon Only (for collapsed state) --}}
            <a href="{{ route('beranda') }}" class="hidden logo-icon flex-shrink-0">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}"
                         alt="GPdI Shekinah" class="h-9 w-9 object-contain">
                @else
                    <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
            </a>

            {{-- Collapse Toggle Button --}}
            <button id="sidebar-collapse" class="p-1.5 rounded-lg text-blue-200 hover:bg-blue-700 transition-colors hidden md:flex">
                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Menu Navigation --}}
        <nav class="flex-1 px-2 py-4 space-y-0.5 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('gembala.dashboard') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('gembala.dashboard') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="sidebar-text sidebar-label">Dashboard</span>
            </a>

            {{-- Section: Konten --}}
            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Konten</p>

            <a href="{{ route('gembala.renungan') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('gembala.renungan*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span class="sidebar-text sidebar-label">Renungan</span>
            </a>

            <a href="{{ route('gembala.pengumuman') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('gembala.pengumuman*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <span class="sidebar-text sidebar-label">Pengumuman</span>
            </a>

            {{-- Section: Jadwal --}}
            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Jadwal</p>

            <a href="{{ route('gembala.jadwal') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('gembala.jadwal*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="sidebar-text sidebar-label">Jadwal Kegiatan</span>
            </a>

            {{-- Section: Akun --}}
            <p class="section-title sidebar-divider text-blue-300 text-[10px] font-semibold uppercase tracking-widest px-3 pt-4 pb-1">Akun</p>

            <a href="{{ route('gembala.profil') }}"
               class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
               {{ request()->routeIs('gembala.profil*') ? 'text-white bg-blue-700' : 'text-blue-100 hover:text-white hover:bg-blue-700' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="sidebar-text sidebar-label">Profil Saya</span>
            </a>

        </nav>

        {{-- User Info + Logout — Web button sudah dihapus, hanya Logout --}}
        <div class="border-t border-blue-700 px-3 py-3">
            <div class="flex items-center gap-3 mb-3">
                @if(auth()->user()->foto && str_starts_with(auth()->user()->foto, 'http'))
                    <img src="{{ auth()->user()->foto }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-8 h-8 rounded-full object-cover flex-shrink-0 ring-2 ring-blue-600 shadow-sm">
                @else
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center flex-shrink-0 ring-2 ring-blue-600 shadow-sm">
                        <svg class="w-4 h-4 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1 min-w-0 user-info-text">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-blue-200 truncate">Gembala</p>
                </div>
            </div>
            <div class="user-actions">
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
        </div>
    </aside>

    {{-- OVERLAY Mobile --}}
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    {{-- KONTEN UTAMA --}}
    <div class="flex-1 flex flex-col transition-all duration-300 md:ml-64" id="main-content">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-100 px-4 md:px-6 py-4 flex items-center justify-between sticky top-0 z-40">
            <div class="flex items-center gap-3">
                {{-- Hamburger Mobile --}}
                <button id="sidebar-toggle"
                        class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg id="icon-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div>
                    <h1 class="font-bold text-gray-900 text-lg">@yield('title')</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('beranda') }}" target="_blank"
                   class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-gray-600 hover:text-blue-700 border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                    🌐 Lihat Website
                </a>
                <div class="text-sm text-gray-500 font-medium hidden sm:block">
                    {{ now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        <div class="px-4 md:px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center justify-between">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700 ml-4">✕</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm flex items-center justify-between">
                    <span>❌ {{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 ml-4">✕</button>
                </div>
            @endif
        </div>

        {{-- Page Content --}}
        <main class="flex-1 px-4 md:px-6 py-6">
            @yield('content')
        </main>

    </div>
</div>

{{-- Scripts --}}
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
            mainContent.classList.add('md:ml-[4.5rem]');
            mainContent.classList.remove('md:ml-64');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            mainContent.classList.remove('md:ml-[4.5rem]');
            mainContent.classList.add('md:ml-64');
        }
    }

    // Event listeners
    sidebarToggle?.addEventListener('click', openSidebar);
    overlay?.addEventListener('click', closeSidebar);
    sidebarCollapse?.addEventListener('click', toggleCollapse);

    // Close sidebar on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });
</script>

@stack('scripts')
</body>
</html>