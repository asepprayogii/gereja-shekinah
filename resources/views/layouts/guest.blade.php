<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name') }}</title>

{{-- Tailwind via jsDelivr (lebih reliable) --}}
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Figtree', sans-serif; }
    /* Tailwind v3 classes yang tidak ada di v2 */
    .backdrop-blur-md { backdrop-filter: blur(12px); }
    .backdrop-blur-sm { backdrop-filter: blur(4px); }
    .bg-clip-text { -webkit-background-clip: text; background-clip: text; }
    .text-transparent { color: transparent; }
    .tracking-tight { letter-spacing: -0.025em; }
    .blur-3xl { filter: blur(64px); }
    .ring-4 { box-shadow: 0 0 0 4px var(--tw-ring-color); }
    .ring-offset-0 { --tw-ring-offset-width: 0px; }
    .rounded-3xl { border-radius: 1.5rem; }
    .rounded-2xl { border-radius: 1rem; }
    .rounded-xl { border-radius: 0.75rem; }
    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
    .from-slate-50 { --tw-gradient-from: #f8fafc; }
    .to-blue-50 { --tw-gradient-to: #eff6ff; }
    .from-blue-900 { --tw-gradient-from: #1e3a8a; }
    .via-blue-800 { --tw-gradient-via: #1e40af; }
    .to-indigo-900 { --tw-gradient-to: #312e81; }
    .from-blue-700 { --tw-gradient-from: #1d4ed8; }
    .to-blue-800 { --tw-gradient-to: #1e40af; }
    .scale-\[0\.99\]:active { transform: scale(0.99); }
    .focus\:ring-4:focus { box-shadow: 0 0 0 4px var(--tw-ring-color); }
    .focus\:ring-blue-100\/50:focus { --tw-ring-color: rgba(219,234,254,0.5); }
    .bg-blue-500\/20 { background-color: rgba(59,130,246,0.2); }
    .bg-indigo-500\/20 { background-color: rgba(99,102,241,0.2); }
    .bg-blue-600\/10 { background-color: rgba(37,99,235,0.1); }
    .bg-white\/15 { background-color: rgba(255,255,255,0.15); }
    .bg-white\/20 { background-color: rgba(255,255,255,0.2); }
    .bg-white\/5 { background-color: rgba(255,255,255,0.05); }
    .bg-white\/10 { background-color: rgba(255,255,255,0.1); }
    .bg-blue-500\/30 { background-color: rgba(59,130,246,0.3); }
    .bg-indigo-500\/30 { background-color: rgba(99,102,241,0.3); }
    .bg-cyan-500\/30 { background-color: rgba(6,182,212,0.3); }
    .border-white\/25 { border-color: rgba(255,255,255,0.25); }
    .border-white\/10 { border-color: rgba(255,255,255,0.1); }
    .text-blue-200\/90 { color: rgba(191,219,254,0.9); }
    .text-blue-200\/80 { color: rgba(191,219,254,0.8); }
    .text-blue-100\/90 { color: rgba(219,234,254,0.9); }
    .hover\:bg-white\/10:hover { background-color: rgba(255,255,255,0.1); }
    .hover\:bg-white\/30:hover { background-color: rgba(255,255,255,0.3); }
    .shadow-blue-700\/30 { box-shadow: 0 10px 15px -3px rgba(29,78,216,0.3); }
    .hover\:shadow-blue-800\/50:hover { box-shadow: 0 10px 15px -3px rgba(30,64,175,0.5); }
    .xl\:text-5xl { font-size: 3rem; }
    @media (min-width: 1280px) { .xl\:text-5xl { font-size: 3rem; line-height: 1; } }
    .group:hover .group-hover\:translate-x-0\.5 { transform: translateX(0.125rem); }
    .group:hover .group-hover\:-translate-x-0\.5 { transform: translateX(-0.125rem); }
    .transition-transform { transition-property: transform; transition-timing-function: cubic-bezier(0.4,0,0.2,1); transition-duration: 150ms; }
</style>
</head>
<body class="antialiased">
{{ $slot }}
</body>
</html>