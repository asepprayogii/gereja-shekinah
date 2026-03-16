<x-guest-layout>

<div class="min-h-screen flex flex-col lg:flex-row" style="background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%)">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden"
         style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #312e81 100%)">

        <div class="absolute inset-0">
            <div class="absolute rounded-full" style="top:25%;left:25%;width:24rem;height:24rem;background:rgba(59,130,246,0.2);filter:blur(64px);animation:pulse 2s infinite"></div>
            <div class="absolute rounded-full" style="bottom:25%;right:25%;width:24rem;height:24rem;background:rgba(99,102,241,0.2);filter:blur:64px;animation:pulse 2s infinite;animation-delay:2s"></div>
        </div>

        <div class="relative z-10 max-w-xl px-12 text-center lg:text-left">

            <div class="flex items-center justify-center lg:justify-start gap-4 mb-10">
                <div style="width:4rem;height:4rem;border-radius:1rem;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center">
                    @if(file_exists(public_path('images/logo-shekinah.png')))
                        <img src="{{ asset('images/logo-shekinah.png') }}" alt="Logo" style="width:2.75rem;height:2.75rem;object-fit:contain">
                    @else
                        <svg style="width:2rem;height:2rem;color:white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M11 2h2v7h7v2h-7v11h-2V11H4V9h7z"/>
                        </svg>
                    @endif
                </div>
                <div>
                    <h1 style="color:white;font-weight:700;font-size:1.5rem;letter-spacing:-0.025em">GPdI Shekinah</h1>
                    <p style="color:rgba(191,219,254,0.9);font-size:0.875rem;font-weight:500">Sistem Informasi Pelayanan</p>
                </div>
            </div>

            <h2 style="font-size:2.5rem;font-weight:700;color:white;line-height:1.2;margin-bottom:1.5rem">
                Kelola Pelayanan <br/>
                <span style="background:linear-gradient(to right,#93c5fd,#67e8f9,#a5b4fc);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Dengan Lebih Mudah</span>
            </h2>

            <p style="color:rgba(219,234,254,0.9);font-size:1.125rem;line-height:1.7;margin-bottom:2.5rem;max-width:28rem">
                Platform terintegrasi untuk pengelolaan jadwal ibadah, koordinasi pelayan, dan informasi jemaat.
            </p>

            <div style="display:flex;flex-direction:column;gap:1rem">
                @foreach([
                    ['Jadwal Otomatis', 'Penjadwalan pelayan ibadah yang cerdas dan fleksibel', 'rgba(59,130,246,0.3)'],
                    ['Data Terpusat', 'Kelola data pelayan dan jemaat dalam satu dashboard', 'rgba(99,102,241,0.3)'],
                    ['Keamanan Terjamin', 'Data dilindungi dengan enkripsi standar industri', 'rgba(6,182,212,0.3)'],
                ] as [$title, $desc, $color])
                <div style="display:flex;align-items:flex-start;gap:1rem;padding:1rem;border-radius:0.75rem;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1)">
                    <div style="width:2.5rem;height:2.5rem;border-radius:0.5rem;background:{{ $color }};display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <svg style="width:1.25rem;height:1.25rem;color:rgba(191,219,254,1)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <h4 style="color:white;font-weight:600;font-size:0.875rem">{{ $title }}</h4>
                        <p style="color:rgba(191,219,254,0.8);font-size:0.75rem;margin-top:0.125rem">{{ $desc }}</p>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div style="flex:1;display:flex;align-items:center;justify-content:center;padding:2rem 1rem;position:relative">

        {{-- Mobile logo --}}
        <div class="lg:hidden" style="position:absolute;top:1rem;left:0;right:0;display:flex;justify-content:center;align-items:center;gap:0.5rem">
            @if(file_exists(public_path('images/logo-shekinah.png')))
                <img src="{{ asset('images/logo-shekinah.png') }}" style="height:1.75rem;width:1.75rem;object-fit:contain" alt="Logo">
            @endif
            <span style="font-weight:700;color:#1f2937;font-size:0.875rem">GPdI Shekinah</span>
        </div>

        <div style="width:100%;max-width:28rem;padding-top:3rem" class="lg:pt-0">

            {{-- Badge --}}
            <div style="margin-bottom:1.5rem;display:flex;justify-content:center" class="lg:justify-start">
                <div style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.5rem 1rem;background:#fffbeb;border:1px solid #fde68a;border-radius:9999px;color:#92400e;font-size:0.75rem;font-weight:500">
                    <svg style="width:0.875rem;height:0.875rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Area Login <strong>Pelayan & Gembala</strong>
                </div>
            </div>

            {{-- Card --}}
            <div style="background:white;border-radius:1.5rem;border:1px solid #f3f4f6;box-shadow:0 25px 50px -12px rgba(0,0,0,0.1);padding:2rem" id="login-card">

                <div style="margin-bottom:2rem;text-align:center" class="lg:text-left">
                    <h2 style="font-size:1.5rem;font-weight:700;color:#111827">Selamat Datang 👋</h2>
                    <p style="color:#6b7280;margin-top:0.375rem;font-size:0.875rem">Masuk untuk mengakses panel pelayanan</p>
                </div>

                @if(session('status'))
                <div style="margin-bottom:1rem;padding:0.75rem 1rem;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:0.75rem;color:#166534;font-size:0.875rem">
                    {{ session('status') }}
                </div>
                @endif

                @if($errors->any())
                <div style="margin-bottom:1.25rem;padding:1rem;background:#fef2f2;border:1px solid #fee2e2;border-radius:0.75rem;color:#b91c1c;font-size:0.875rem;display:flex;align-items:flex-start;gap:0.75rem">
                    <svg style="width:1.25rem;height:1.25rem;flex-shrink:0;margin-top:0.125rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.25rem">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" style="display:block;font-size:0.75rem;font-weight:600;color:#374151;margin-bottom:0.375rem">Email</label>
                        <div style="position:relative">
                            <div style="position:absolute;top:50%;left:1rem;transform:translateY(-50%);pointer-events:none">
                                <svg style="height:1.25rem;width:1.25rem;color:#9ca3af" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username"
                                   placeholder="nama@contoh.com"
                                   style="width:100%;padding:0.75rem 1rem 0.75rem 2.75rem;border:1px solid #e5e7eb;border-radius:0.75rem;font-size:0.875rem;color:#111827;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                   onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.375rem">
                            <label for="password" style="font-size:0.75rem;font-weight:600;color:#374151">Password</label>
                            @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:0.75rem;color:#2563eb;font-weight:500;text-decoration:none">Lupa password?</a>
                            @endif
                        </div>
                        <div style="position:relative">
                            <div style="position:absolute;top:50%;left:1rem;transform:translateY(-50%);pointer-events:none">
                                <svg style="height:1.25rem;width:1.25rem;color:#9ca3af" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••"
                                   style="width:100%;padding:0.75rem 3rem 0.75rem 2.75rem;border:1px solid #e5e7eb;border-radius:0.75rem;font-size:0.875rem;color:#111827;outline:none;box-sizing:border-box;transition:border-color 0.2s"
                                   onfocus="this.style.borderColor='#3b82f6';this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.1)'"
                                   onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                            <button type="button" onclick="togglePwd()"
                                    style="position:absolute;top:50%;right:1rem;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9ca3af;padding:0">
                                <svg id="eye-icon" style="height:1.25rem;width:1.25rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember --}}
                    <div style="display:flex;align-items:center;gap:0.625rem">
                        <input id="remember_me" type="checkbox" name="remember"
                               style="width:1rem;height:1rem;border-radius:0.25rem;border:1px solid #d1d5db;cursor:pointer;accent-color:#2563eb">
                        <label for="remember_me" style="font-size:0.875rem;color:#4b5563;cursor:pointer">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            style="width:100%;padding:0.875rem;background:linear-gradient(to right,#1d4ed8,#1e40af);color:white;border:none;border-radius:0.75rem;font-weight:600;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:0.5rem;transition:opacity 0.2s;box-shadow:0 4px 14px rgba(29,78,216,0.35)"
                            onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Masuk ke Panel
                        <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </form>

                {{-- Divider --}}
                <div style="position:relative;margin:1.75rem 0">
                    <div style="position:absolute;inset:0;display:flex;align-items:center">
                        <div style="width:100%;border-top:1px solid #f3f4f6"></div>
                    </div>
                    <div style="position:relative;display:flex;justify-content:center">
                        <span style="padding:0 0.75rem;background:white;color:#9ca3af;font-size:0.75rem;font-weight:500">Akses Terbatas</span>
                    </div>
                </div>

                {{-- Back to home --}}
                <a href="{{ url('/') }}"
                   style="width:100%;display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.625rem 1rem;border:1px solid #e5e7eb;border-radius:0.75rem;color:#4b5563;font-size:0.875rem;font-weight:500;text-decoration:none;margin-bottom:1.25rem;transition:background 0.2s"
                   onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                    <svg style="width:1rem;height:1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>

                <p style="text-align:center;font-size:0.75rem;color:#9ca3af;line-height:1.6">
                    Sistem ini hanya dapat diakses oleh pengguna terdaftar.<br>
                    Hubungi administrator gereja untuk permohonan akses.
                </p>
            </div>

            <p style="text-align:center;font-size:0.75rem;color:#9ca3af;margin-top:1.5rem">
                © {{ date('Y') }} <strong style="color:#6b7280">GPdI Shekinah</strong>. All rights reserved.
            </p>
        </div>
    </div>
</div>

<script>
function togglePwd() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eye-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const card = document.getElementById('login-card');
    if (card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(10px)';
        card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        setTimeout(() => { card.style.opacity='1'; card.style.transform='translateY(0)'; }, 100);
    }
});
</script>

</x-guest-layout>