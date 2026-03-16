@extends('layouts.publik')
@section('title', 'Musik Pujian')

@section('content')

<div class="max-w-6xl mx-auto px-5 py-16">

    {{-- Header --}}
    <div class="mb-12">
        <p class="text-xs uppercase tracking-[0.25em] text-blue-500 font-medium mb-2">Pujian & Penyembahan</p>
        <h1 class="text-3xl font-bold text-gray-900">Musik Pujian</h1>
        <div class="w-10 h-0.5 bg-blue-600 mt-4"></div>
    </div>

    @if($musik->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ===== PLAYER KIRI ===== --}}
        <div class="lg:col-span-3">
            <div class="bg-gray-950 rounded-2xl overflow-hidden sticky top-20 p-8">

                {{-- Album art / cover --}}
                <div class="relative w-52 h-52 mx-auto mb-8">
                    {{-- Lingkaran dekoratif luar --}}
                    <div class="absolute inset-0 rounded-full border-2 border-white/5"></div>
                    <div class="absolute -inset-3 rounded-full border border-white/5"></div>

                    {{-- Cover thumbnail --}}
                    <div id="player-cover"
                         class="w-full h-full rounded-full overflow-hidden shadow-2xl ring-4 ring-white/5
                                relative flex items-center justify-center bg-gray-800">
                        <img id="player-thumb"
                             src="{{ $playlist[0]['thumbnail'] ?? '' }}"
                             alt="{{ $playlist[0]['judul_lagu'] ?? '' }}"
                             class="w-full h-full object-cover rounded-full"
                             onerror="this.classList.add('hidden');document.getElementById('cover-fallback').classList.remove('hidden')">
                        <div id="cover-fallback" class="hidden absolute inset-0 flex items-center justify-center">
                            <svg class="w-20 h-20 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                      d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        {{-- Spinning animation saat play --}}
                        <div id="spin-ring" class="hidden absolute inset-0 rounded-full border-2 border-t-blue-400 border-r-transparent border-b-transparent border-l-transparent animate-spin"></div>
                    </div>
                </div>

                {{-- Info lagu aktif --}}
                <div class="text-center mb-6">
                    <p id="player-judul" class="font-bold text-white text-xl leading-snug mb-1 truncate">
                        {{ $playlist[0]['judul_lagu'] ?? '-' }}
                    </p>
                    <p id="player-penyanyi" class="text-sm text-gray-400">
                        {{ $playlist[0]['penyanyi'] ?? '' }}
                    </p>
                </div>

                {{-- Progress bar (visual only) --}}
                <div class="flex items-center gap-3 mb-6">
                    <span class="text-xs text-gray-600 w-8 text-right" id="time-current">0:00</span>
                    <div class="flex-1 h-1 bg-gray-800 rounded-full overflow-hidden cursor-pointer" id="progress-bar" onclick="seekTo(event)">
                        <div id="progress-fill" class="h-full bg-blue-500 rounded-full transition-none" style="width:0%"></div>
                    </div>
                    <span class="text-xs text-gray-600 w-8" id="time-total">—</span>
                </div>

                {{-- Controls --}}
                <div class="flex items-center justify-center gap-4">
                    {{-- Prev --}}
                    <button onclick="prevTrack()"
                            class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 6h2v12H6zm3.5 6 8.5 6V6z"/>
                        </svg>
                    </button>

                    {{-- Play / Pause --}}
                    <button onclick="togglePlay()"
                            id="btn-play"
                            class="w-14 h-14 rounded-full bg-white flex items-center justify-center
                                   hover:bg-gray-100 transition-colors shadow-lg">
                        {{-- Play icon --}}
                        <svg id="icon-play" class="w-6 h-6 text-gray-900 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                        {{-- Pause icon (hidden by default) --}}
                        <svg id="icon-pause" class="w-6 h-6 text-gray-900 hidden" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                        </svg>
                    </button>

                    {{-- Next --}}
                    <button onclick="nextTrack()"
                            class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6 18l8.5-6L6 6v12zm2-8.14L11.03 12 8 14.14V9.86zM16 6h2v12h-2z"/>
                        </svg>
                    </button>
                </div>

                {{-- Counter --}}
                <p class="text-center text-xs text-gray-600 mt-5" id="track-counter">
                    1 / {{ count($playlist) }}
                </p>

                {{-- Hidden YouTube iframe (audio only trick) --}}
                <div id="yt-hidden" class="hidden absolute -top-96 -left-96 w-1 h-1 overflow-hidden">
                    <div id="iframe-container"></div>
                </div>

            </div>
        </div>

        {{-- ===== PLAYLIST KANAN ===== --}}
        <div class="lg:col-span-2">

            {{-- Search --}}
            <div class="relative mb-3">
                <input type="text"
                       id="search-input"
                       oninput="filterPlaylist(this.value)"
                       placeholder="Cari lagu..."
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 pl-9 text-sm
                              focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-transparent
                              bg-white placeholder-gray-400">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-50">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                        Playlist · <span id="playlist-count">{{ count($playlist) }}</span> lagu
                    </p>
                </div>
                <div class="overflow-y-auto max-h-[460px]" id="playlist-container">
                    @foreach($playlist as $i => $lagu)
                    <div id="track-{{ $i }}"
                         data-judul="{{ strtolower($lagu['judul_lagu']) }}"
                         data-penyanyi="{{ strtolower($lagu['penyanyi'] ?? '') }}"
                         onclick="selectTrack({{ $i }})"
                         class="track-item flex items-center gap-3 px-4 py-3.5 cursor-pointer
                                hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0
                                {{ $i === 0 ? 'bg-blue-50' : '' }} group">

                        {{-- Thumbnail --}}
                        <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 relative">
                            <img src="{{ $lagu['thumbnail'] }}"
                                 alt="{{ $lagu['judul_lagu'] }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $lagu['video_id'] }}/hqdefault.jpg'">
                            <div id="playing-indicator-{{ $i }}"
                                 class="{{ $i === 0 ? '' : 'hidden' }} absolute inset-0 bg-blue-600/85
                                        flex items-center justify-center">
                                {{-- Equalizer bars --}}
                                <div class="flex items-end gap-0.5 h-4">
                                    <div class="w-1 bg-white rounded-sm equalizer-bar" style="animation: eq 0.8s ease infinite; height:60%"></div>
                                    <div class="w-1 bg-white rounded-sm equalizer-bar" style="animation: eq 0.8s ease infinite 0.2s; height:100%"></div>
                                    <div class="w-1 bg-white rounded-sm equalizer-bar" style="animation: eq 0.8s ease infinite 0.1s; height:40%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 leading-snug truncate
                                      {{ $i === 0 ? 'text-blue-700' : '' }}" id="track-title-{{ $i }}">
                                {{ $lagu['judul_lagu'] }}
                            </p>
                            @if($lagu['penyanyi'])
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $lagu['penyanyi'] }}</p>
                            @endif
                        </div>

                        {{-- Nomor / arrow --}}
                        <span class="text-xs text-gray-300 flex-shrink-0 group-hover:hidden
                                     {{ $i === 0 ? 'hidden' : '' }}">
                            {{ $i + 1 }}
                        </span>
                        <svg class="w-3.5 h-3.5 text-gray-300 flex-shrink-0 hidden group-hover:block
                                    {{ $i === 0 ? '!block text-blue-400' : '' }}"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    @endforeach

                    {{-- Empty search state --}}
                    <div id="no-results" class="hidden px-5 py-8 text-center">
                        <p class="text-sm text-gray-400">Lagu tidak ditemukan.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @else
    <div class="bg-white rounded-2xl border border-gray-100 p-14 text-center">
        <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.25"
                  d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
        </svg>
        <p class="text-sm text-gray-400">Belum ada musik pujian.</p>
    </div>
    @endif

</div>

<style>
@keyframes eq {
    0%, 100% { transform: scaleY(0.4); }
    50%       { transform: scaleY(1); }
}
.equalizer-bar { transform-origin: bottom; }

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
#player-cover.is-playing { animation: spin-slow 8s linear infinite; }
</style>

@push('scripts')
<script>
const playlist = @json($playlist);
let currentTrack = 0;
let isPlaying = false;
let ytPlayer = null;
let progressTimer = null;

// Inisialisasi YouTube IFrame API (hidden)
function loadYouTubeAPI() {
    if (window.YT) { createPlayer(playlist[0].video_id); return; }
    const tag = document.createElement('script');
    tag.src = 'https://www.youtube.com/iframe_api';
    document.head.appendChild(tag);
}

window.onYouTubeIframeAPIReady = function() {
    createPlayer(playlist[currentTrack].video_id);
};

function createPlayer(videoId) {
    if (ytPlayer) { ytPlayer.destroy(); }
    document.getElementById('iframe-container').innerHTML = '<div id="yt-player"></div>';
    ytPlayer = new YT.Player('yt-player', {
        height: '1',
        width: '1',
        videoId: videoId,
        playerVars: { autoplay: 0, controls: 0 },
        events: {
            onReady: onPlayerReady,
            onStateChange: onPlayerStateChange,
        }
    });
}

function onPlayerReady(event) {
    updateDuration();
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.ENDED) {
        nextTrack();
    }
    if (event.data === YT.PlayerState.PLAYING) {
        setPlayingState(true);
        startProgressTimer();
    } else {
        setPlayingState(false);
        clearInterval(progressTimer);
    }
}

function onPlayerReady(e) {
    setTimeout(updateDuration, 800);
}

function updateDuration() {
    if (!ytPlayer || !ytPlayer.getDuration) return;
    const dur = ytPlayer.getDuration();
    if (dur > 0) {
        document.getElementById('time-total').textContent = formatTime(dur);
    }
}

function startProgressTimer() {
    clearInterval(progressTimer);
    progressTimer = setInterval(() => {
        if (!ytPlayer || !ytPlayer.getCurrentTime) return;
        const cur = ytPlayer.getCurrentTime();
        const dur = ytPlayer.getDuration();
        if (dur > 0) {
            document.getElementById('progress-fill').style.width = (cur / dur * 100) + '%';
            document.getElementById('time-current').textContent = formatTime(cur);
            document.getElementById('time-total').textContent = formatTime(dur);
        }
    }, 500);
}

function formatTime(sec) {
    const m = Math.floor(sec / 60);
    const s = Math.floor(sec % 60);
    return m + ':' + (s < 10 ? '0' : '') + s;
}

function seekTo(e) {
    if (!ytPlayer || !ytPlayer.seekTo) return;
    const bar = document.getElementById('progress-bar');
    const rect = bar.getBoundingClientRect();
    const pct = (e.clientX - rect.left) / rect.width;
    const dur = ytPlayer.getDuration();
    ytPlayer.seekTo(pct * dur, true);
}

function setPlayingState(playing) {
    isPlaying = playing;
    document.getElementById('icon-play').classList.toggle('hidden', playing);
    document.getElementById('icon-pause').classList.toggle('hidden', !playing);
    document.getElementById('spin-ring').classList.toggle('hidden', !playing);
}

function selectTrack(index) {
    // Reset semua
    playlist.forEach((_, i) => {
        const row   = document.getElementById('track-' + i);
        const ind   = document.getElementById('playing-indicator-' + i);
        const title = document.getElementById('track-title-' + i);
        if (row)   row.classList.remove('bg-blue-50');
        if (ind)   ind.classList.add('hidden');
        if (title) title.classList.remove('text-blue-700');
    });

    currentTrack = index;
    const lagu = playlist[index];

    // Update player info
    document.getElementById('player-judul').textContent    = lagu.judul_lagu;
    document.getElementById('player-penyanyi').textContent = lagu.penyanyi || '';
    document.getElementById('track-counter').textContent   = (index + 1) + ' / ' + playlist.length;

    // Update thumbnail
    const thumb = document.getElementById('player-thumb');
    thumb.src = lagu.thumbnail || ('https://img.youtube.com/vi/' + lagu.video_id + '/hqdefault.jpg');
    thumb.classList.remove('hidden');
    document.getElementById('cover-fallback').classList.add('hidden');

    // Active styling
    const activeRow   = document.getElementById('track-' + index);
    const activeInd   = document.getElementById('playing-indicator-' + index);
    const activeTitle = document.getElementById('track-title-' + index);
    if (activeRow)   activeRow.classList.add('bg-blue-50');
    if (activeInd)   activeInd.classList.remove('hidden');
    if (activeTitle) activeTitle.classList.add('text-blue-700');

    if (activeRow) activeRow.scrollIntoView({ block: 'nearest', behavior: 'smooth' });

    // Load & play
    document.getElementById('progress-fill').style.width = '0%';
    document.getElementById('time-current').textContent = '0:00';
    document.getElementById('time-total').textContent = '—';

    if (ytPlayer && ytPlayer.loadVideoById) {
        ytPlayer.loadVideoById(lagu.video_id);
    } else {
        createPlayer(lagu.video_id);
    }
}

function togglePlay() {
    if (!ytPlayer) { selectTrack(currentTrack); return; }
    if (isPlaying) {
        ytPlayer.pauseVideo();
    } else {
        if (ytPlayer.getPlayerState() === -1 || ytPlayer.getPlayerState() === 5) {
            ytPlayer.loadVideoById(playlist[currentTrack].video_id);
        } else {
            ytPlayer.playVideo();
        }
    }
}

function nextTrack() {
    selectTrack((currentTrack + 1) % playlist.length);
}

function prevTrack() {
    selectTrack((currentTrack - 1 + playlist.length) % playlist.length);
}

function filterPlaylist(query) {
    const q = query.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.track-item').forEach(el => {
        const judul    = el.dataset.judul || '';
        const penyanyi = el.dataset.penyanyi || '';
        const match    = !q || judul.includes(q) || penyanyi.includes(q);
        el.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    document.getElementById('playlist-count').textContent = visible;
    document.getElementById('no-results').classList.toggle('hidden', visible > 0);
}

// Load YouTube API on page load
loadYouTubeAPI();
</script>
@endpush

@endsection