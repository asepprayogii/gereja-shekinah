@extends('layouts.publik')
@section('title', 'Tentang Gereja')

@section('content')

<div class="max-w-5xl mx-auto px-5 py-16">

    {{-- Header --}}
    <div class="mb-14">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Profil</p>
        <h1 class="text-3xl font-bold text-gray-900">Tentang Gereja</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    {{-- ── BARIS 1: Profil full width ── --}}
    <div class="bg-white border border-gray-100 rounded-2xl p-8 mb-5">
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-4">Profil Gereja</p>
        <p class="text-sm text-gray-600 leading-relaxed max-w-3xl">
            {{ $about->deskripsi ?? 'GPdI Jemaat "Shekinah" Pangkalan Buntu adalah gereja yang berdiri di bawah naungan Gereja Pantekosta di Indonesia, melayani jemaat dengan kasih dan kebenaran Firman Tuhan.' }}
        </p>
    </div>

    {{-- ── BARIS 2: Visi & Misi side by side ── --}}
    @if($about->visi || $about->misi)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

        @if($about->visi)
        <div class="bg-blue-950 rounded-2xl p-8 flex flex-col">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-7 h-7 rounded-lg bg-blue-800 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-blue-400">Visi</p>
            </div>
            <p class="text-white text-sm leading-relaxed">{{ $about->visi }}</p>
        </div>
        @endif

        @if($about->misi)
        <div class="bg-white border border-gray-100 rounded-2xl p-8 flex flex-col">
            <div class="flex items-center gap-2 mb-5">
                <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Misi</p>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">{{ $about->misi }}</p>
        </div>
        @endif

    </div>
    @endif

    {{-- ── BARIS 3: Kontak & Sosmed side by side ── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Kontak --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-8">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-6">Kontak & Lokasi</p>
            <div class="space-y-5">

                @if($about->alamat)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Alamat</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $about->alamat }}</p>
                    </div>
                </div>
                @endif

                @if($about->no_hp)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Telepon / WhatsApp</p>
                        <a href="https://wa.me/{{ preg_replace('/\D/','',$about->no_hp) }}" target="_blank"
                           class="text-sm text-gray-700 hover:text-green-600 transition-colors">
                            {{ $about->no_hp }}
                        </a>
                    </div>
                </div>
                @endif

                @if($about->email)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-0.5">Email</p>
                        <a href="mailto:{{ $about->email }}"
                           class="text-sm text-gray-700 hover:text-blue-600 transition-colors">
                            {{ $about->email }}
                        </a>
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- Media Sosial --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-8">
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-6">Media Sosial</p>

            @php
            $sosmed = [
                'instagram' => [
                    'label' => 'Instagram',
                    'color_hover' => 'hover:border-pink-200 hover:bg-pink-50',
                    'color_text'  => 'group-hover:text-pink-600',
                    'color_icon'  => 'group-hover:text-pink-500',
                    'icon' => '<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>',
                ],
                'youtube' => [
                    'label' => 'YouTube',
                    'color_hover' => 'hover:border-red-200 hover:bg-red-50',
                    'color_text'  => 'group-hover:text-red-600',
                    'color_icon'  => 'group-hover:text-red-500',
                    'icon' => '<path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>',
                ],
                'facebook' => [
                    'label' => 'Facebook',
                    'color_hover' => 'hover:border-blue-200 hover:bg-blue-50',
                    'color_text'  => 'group-hover:text-blue-600',
                    'color_icon'  => 'group-hover:text-blue-500',
                    'icon' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
                ],
                'tiktok' => [
                    'label' => 'TikTok',
                    'color_hover' => 'hover:border-gray-300 hover:bg-gray-50',
                    'color_text'  => 'group-hover:text-gray-900',
                    'color_icon'  => 'group-hover:text-gray-700',
                    'icon' => '<path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>',
                ],
            ];
            @endphp

            <div class="space-y-2">
                @foreach($sosmed as $field => $meta)
                    @if($about->$field)
                    @php
                        // Ekstrak username dari URL
                        $url = $about->$field;
                        $username = rtrim(parse_url($url, PHP_URL_PATH), '/');
                        $username = ltrim($username, '/@');
                        // Untuk YouTube bisa berupa /channel/xxx atau @xxx
                        if(str_contains($url, 'youtube') && str_contains($url, '/channel/')) {
                            $username = 'YouTube Channel';
                        } elseif(str_contains($url, 'youtube') && str_contains($url, '@')) {
                            preg_match('/@([^\/\?]+)/', $url, $m);
                            $username = isset($m[1]) ? '@'.$m[1] : $username;
                        } elseif(!str_contains($username, '@')) {
                            $username = '@'.$username;
                        }
                    @endphp
                    <a href="{{ $url }}" target="_blank"
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-100 transition-all {{ $meta['color_hover'] }}">
                        <svg class="w-4 h-4 text-gray-300 flex-shrink-0 transition-colors {{ $meta['color_icon'] }}"
                             fill="currentColor" viewBox="0 0 24 24">
                            {!! $meta['icon'] !!}
                        </svg>
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide leading-none mb-0.5">
                                {{ $meta['label'] }}
                            </p>
                            <p class="text-xs text-gray-600 truncate transition-colors {{ $meta['color_text'] }}">
                                {{ $username }}
                            </p>
                        </div>
                        <svg class="w-3 h-3 text-gray-300 flex-shrink-0 group-hover:translate-x-0.5 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @endif
                @endforeach
            </div>

        </div>

    </div>

</div>
@endsection