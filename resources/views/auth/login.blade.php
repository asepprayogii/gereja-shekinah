<x-guest-layout>

<div class="min-h-screen flex flex-col lg:flex-row bg-gradient-to-br from-slate-50 to-blue-50">

    {{-- LEFT SIDE - Branding --}}
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
        
        {{-- Animated Background --}}
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-3xl"></div>
        </div>

        {{-- Pattern Overlay --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

        <div class="relative z-10 max-w-xl px-12 text-center lg:text-left">
            
            {{-- Logo Section --}}
            <div class="flex items-center justify-center lg:justify-start gap-4 mb-10">
                <div class="w-16 h-16 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center border border-white/25 shadow-lg shadow-blue-900/20">
                    @if(file_exists(public_path('images/logo-shekinah.png')))
                        <img src="{{ asset('images/logo-shekinah.png') }}" alt="Logo GPdI Shekinah" class="w-11 h-11 object-contain">
                    @else
                        <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 class="text-white font-bold text-2xl tracking-tight">GPdI Shekinah</h1>
                    <p class="text-blue-200/90 text-sm font-medium">Sistem Informasi Pelayanan</p>
                </div>
            </div>

            {{-- Main Heading --}}
            <h2 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-6">
                Kelola Pelayanan <br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 via-cyan-300 to-indigo-300">Dengan Lebih Mudah</span>
            </h2>

            <p class="text-blue-100/90 text-lg leading-relaxed mb-10 max-w-md">
                Platform terintegrasi untuk pengelolaan jadwal ibadah, koordinasi pelayan, dan informasi jemaat dalam satu sistem yang aman dan modern.
            </p>

            {{-- Features Grid --}}
            <div class="grid grid-cols-1 gap-4">
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-blue-500/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm">Jadwal Otomatis</h4>
                        <p class="text-blue-200/80 text-xs mt-0.5">Penjadwalan pelayan ibadah yang cerdas dan fleksibel</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-indigo-500/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm">Data Terpusat</h4>
                        <p class="text-blue-200/80 text-xs mt-0.5">Kelola data pelayan dan jemaat dalam satu dashboard</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-colors">
                    <div class="w-10 h-10 rounded-lg bg-cyan-500/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold text-sm">Keamanan Terjamin</h4>
                        <p class="text-blue-200/80 text-xs mt-0.5">Data dilindungi dengan enkripsi standar industri</p>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- RIGHT SIDE - Login Form --}}
    <div class="flex-1 flex items-center justify-center px-4 py-8 lg:py-12 relative">
        
        {{-- Mobile Header --}}
        <div class="lg:hidden absolute top-4 left-0 right-0 flex items-center justify-center gap-2 px-4">
            <div class="flex items-center gap-2">
                @if(file_exists(public_path('images/logo-shekinah.png')))
                    <img src="{{ asset('images/logo-shekinah.png') }}" alt="Logo" class="h-7 w-7 object-contain">
                @else
                    <div class="w-7 h-7 rounded-lg bg-blue-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    </div>
                @endif
                <span class="font-bold text-gray-800 text-sm">GPdI Shekinah</span>
            </div>
        </div>

        <div class="w-full max-w-md pt-12 lg:pt-0">

            {{-- Role Badge --}}
            <div class="mb-6 flex justify-center lg:justify-start">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 rounded-full text-amber-800 text-xs font-medium shadow-sm">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>Area Login <strong>Pelayan & Gembala</strong></span>
                </div>
            </div>

            {{-- Login Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-2xl shadow-gray-200/60 p-6 sm:p-8">
                
                {{-- Header --}}
                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang 👋</h2>
                    <p class="text-gray-500 mt-1.5 text-sm">Masuk untuk mengakses panel pelayanan</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                {{-- Error Alert --}}
                @if($errors->any())
                <div class="mb-5 p-4 bg-red-50 border border-red-100 rounded-xl text-red-700 text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-700 text-sm font-semibold mb-2 block" />
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <x-text-input
                                id="email"
                                class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 placeholder-gray-400 text-sm"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@contoh.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500" />
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <x-input-label for="password" :value="__('Password')" class="text-gray-700 text-sm font-semibold" />
                            @if (Route::has('password.request'))
                                <a class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <x-text-input
                                id="password"
                                class="block w-full pl-11 pr-12 py-3 border border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 transition-all text-gray-900 placeholder-gray-400 text-sm"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                            />
                            {{-- Toggle Password Visibility --}}
                            <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors" onclick="togglePasswordVisibility('password')">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500" />
                    </div>

                    {{-- REMEMBER ME --}}
                    <div class="flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer transition-colors"
                            name="remember"
                        >
                        <label for="remember_me" class="ml-2.5 text-sm text-gray-600 cursor-pointer select-none hover:text-gray-800 transition-colors">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- LOGIN BUTTON --}}
                    <div class="pt-3">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-700 to-blue-800 hover:from-blue-800 hover:to-blue-900 text-white py-3.5 rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-blue-700/30 hover:shadow-blue-800/50 active:scale-[0.99] flex items-center justify-center gap-2 group"
                        >
                            <span>Masuk ke Panel</span>
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>

                </form>

                {{-- Divider --}}
                <div class="relative my-7">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
                    <div class="relative flex justify-center text-xs"><span class="px-3 bg-white text-gray-400 font-medium">Akses Terbatas</span></div>
                </div>

                {{-- Back to Home Button (NEW!) --}}
                <div class="mb-5">
                    <a href="{{ url('/') }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 text-sm font-medium transition-all duration-200 group">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

                {{-- Footer Note --}}
                <p class="text-center text-xs text-gray-400 leading-relaxed">
                    Sistem ini hanya dapat diakses oleh pengguna terdaftar.<br>
                    Hubungi administrator gereja untuk permohonan akses.
                </p>

            </div>

            {{-- Copyright --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} <strong class="text-gray-500">GPdI Shekinah</strong>. All rights reserved.
            </p>

        </div>
    </div>

</div>

{{-- Custom Styles & Scripts --}}
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Smooth focus transitions */
    input:focus {
        outline: none;
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    // Toggle password visibility
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const eyeIcon = document.getElementById('eye-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            `;
        } else {
            input.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        }
    }
    
    // Add subtle entrance animation on load
    document.addEventListener('DOMContentLoaded', function() {
        const loginCard = document.querySelector('.bg-white.rounded-3xl');
        if (loginCard) {
            loginCard.style.opacity = '0';
            loginCard.style.transform = 'translateY(10px)';
            loginCard.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            
            setTimeout(() => {
                loginCard.style.opacity = '1';
                loginCard.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>

</x-guest-layout>