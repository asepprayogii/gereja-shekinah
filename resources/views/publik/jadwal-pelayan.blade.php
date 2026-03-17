@extends('layouts.publik')
@section('title', 'Tim Pelayan')

@section('content')

<div class="max-w-4xl mx-auto px-5 py-16">

    {{-- Header --}}
    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Ibadah Minggu</p>
        <h1 class="text-3xl font-bold text-gray-900">Tim Pelayan</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    {{-- Info Minggu Aktif --}}
    <div class="flex items-center gap-4 bg-blue-950 text-white rounded-2xl px-6 py-5 mb-10">
        <div class="w-10 h-10 rounded-xl bg-blue-800 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs text-blue-400 uppercase tracking-widest font-medium">Ibadah Minggu</p>
            <p class="font-bold text-white mt-0.5 text-lg">{{ $tanggalIbadah->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="ml-auto">
            <span class="bg-blue-700 text-blue-200 text-[10px] font-semibold uppercase tracking-widest px-3 py-1.5 rounded-full">
                Minggu Ini
            </span>
        </div>
    </div>

    {{-- Jadwal --}}
    @php
        use App\Models\JadwalIbadahMinggu;

        $grupPosisi  = JadwalIbadahMinggu::$grupPosisi;
        $posisiList  = JadwalIbadahMinggu::$posisiList;

        // Index jadwal by posisi key, hanya yang ada nama & is_visible
        $jadwalByPosisi = [];
        foreach ($jadwal as $j) {
            if ($j->nama_pelayan && $j->is_visible) {
                $jadwalByPosisi[$j->posisi] = $j;
            }
        }

        // Bangun peta prefix → grup (untuk posisi dinamis)
        $prefixToGrup = [];
        foreach ($grupPosisi as $grupNama => $keys) {
            foreach ($keys as $k) {
                $prefix = preg_replace('/_\d+$/', '', $k);
                $prefixToGrup[$prefix] = $grupNama;
            }
        }

        // Kelompokkan semua jadwal ke grup
        $jadwalPerGrup = [];
        foreach ($jadwalByPosisi as $posKey => $j) {
            $grup = null;
            // exact match dari grupPosisi
            foreach ($grupPosisi as $grupNama => $keys) {
                if (in_array($posKey, $keys)) { $grup = $grupNama; break; }
            }
            // prefix match untuk posisi dinamis
            if (!$grup) {
                $prefix = preg_replace('/_\d+$/', '', $posKey);
                if (isset($prefixToGrup[$prefix])) {
                    $grup = $prefixToGrup[$prefix];
                }
            }
            if ($grup) {
                $jadwalPerGrup[$grup][] = $j;
            }
        }

        $adaJadwal = collect($jadwalPerGrup)->flatten()->count() > 0;
    @endphp

    @if($adaJadwal)
    <div class="space-y-8 mb-10">
        @foreach($grupPosisi as $grupNama => $keys)
        @php $anggota = $jadwalPerGrup[$grupNama] ?? []; @endphp
        @if(count($anggota) > 0)
        <div>
            {{-- Label grup --}}
            <div class="flex items-center gap-3 mb-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 whitespace-nowrap">{{ $grupNama }}</span>
                <div class="flex-1 h-px bg-gray-100"></div>
            </div>

            {{-- Cards --}}
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($anggota as $j)
                @php
                    $userPelayan = isset($users)
                        ? $users->first(fn($u) => $u->name === $j->nama_pelayan)
                        : null;
                    $fotoUrl = $userPelayan && $userPelayan->foto
                        ? $userPelayan->foto
                        : null;
                    $labelPosisi = $posisiList[$j->posisi]
                        ?? ucwords(str_replace('_', ' ', $j->posisi));
                @endphp
                <div class="bg-white border border-gray-100 rounded-2xl p-4 flex flex-col items-center text-center
                            hover:border-blue-100 hover:shadow-sm transition-all w-36">

                    {{-- Foto / Avatar --}}
                    <div class="w-16 h-16 rounded-full overflow-hidden mb-3 flex-shrink-0
                                {{ $fotoUrl ? '' : 'bg-gradient-to-br from-blue-50 to-blue-100' }}
                                ring-2 ring-white shadow-md">
                        @if($fotoUrl)
                            <img src="{{ $fotoUrl }}" alt="{{ $j->nama_pelayan }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Label posisi --}}
                    <p class="text-[10px] font-semibold uppercase tracking-widest text-blue-500 mb-1 leading-tight">
                        {{ $labelPosisi }}
                    </p>

                    {{-- Nama --}}
                    <p class="text-sm font-bold text-gray-900 leading-snug">{{ $j->nama_pelayan }}</p>

                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </div>

    @else
    <div class="bg-white border border-gray-100 rounded-2xl p-12 text-center mb-10">
        <svg class="w-8 h-8 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <p class="text-sm text-gray-400">Jadwal pelayan minggu ini belum tersedia.</p>
    </div>
    @endif

    {{-- Jadwal Rutin --}}
    <div class="bg-gray-50 rounded-2xl p-6">
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-4">Jadwal Ibadah Rutin</p>
        <div class="space-y-2.5">
            @foreach([
                ['Senin',  'Ibadah Kaum Wanita', '16.00'],
                ['Selasa', 'Ibadah Kemah Pniel',  '19.00'],
                ['Rabu',   'Ibadah Mahanaim',     '19.00'],
                ['Kamis',  'Ibadah Filadelfia',   '19.00'],
                ['Jumat',  'Doa Syafaat',         '17.00'],
                ['Jumat',  'Latihan Musik',        '19.00'],
                ['Sabtu',  'Ibadah Pemuda',        '19.00'],
                ['Minggu', 'Sekolah Minggu',       '10.00'],
                ['Minggu', 'Ibadah Raya',          '10.00'],
            ] as [$hari, $nama, $jam])
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">{{ $nama }}</p>
                <p class="text-xs text-gray-400 font-medium">{{ $hari }}, {{ $jam }} WIB</p>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection