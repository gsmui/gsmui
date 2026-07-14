@blaze(fold: true)

@props([
    'src' => null,
    'poster' => null,
    'autoplay' => false,
    'muted' => false,
    'loop' => false,
    'aspectRatio' => '16/9',
])

@php
$aspectMap = [
    '16/9' => 'aspect-video',
    '4/3' => 'aspect-[4/3]',
    '1/1' => 'aspect-square',
];

$classes = Gsmui::classes()
    ->add('relative w-full overflow-hidden rounded-xl')
    ->add($aspectMap[$aspectRatio] ?? 'aspect-video')
    ->add('bg-zinc-900 border border-zinc-700')
    ;
@endphp

<div
    x-data="{
        isPlaying: false,
        currentTime: 0,
        duration: 0,
        progress: 0,
        showControls: true,
        isMuted: false,
        hideTimeout: null,
        init() {
            const video = this.$refs.video;
            video.addEventListener('timeupdate', () => {
                this.currentTime = video.currentTime;
                this.progress = video.duration ? (video.currentTime / video.duration) * 100 : 0;
            });
            video.addEventListener('loadedmetadata', () => {
                this.duration = video.duration;
            });
            video.addEventListener('ended', () => {
                this.isPlaying = false;
            });
        },
        togglePlay() {
            const video = this.$refs.video;
            if (this.isPlaying) {
                video.pause();
            } else {
                video.play();
            }
            this.isPlaying = !this.isPlaying;
        },
        seek(event) {
            const video = this.$refs.video;
            const rect = event.currentTarget.getBoundingClientRect();
            const pos = (event.clientX - rect.left) / rect.width;
            video.currentTime = Math.max(0, Math.min(pos * video.duration, video.duration));
        },
        toggleMute() {
            this.isMuted = !this.isMuted;
            this.$refs.video.muted = this.isMuted;
        },
        formatTime(time) {
            if (!time || isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
    }"
    {{ $attributes->class($classes) }}
    data-gsmui-video-gaming
    x-on:mouseenter="showControls = true; clearTimeout(hideTimeout)"
    x-on:mouseleave="showControls = !isPlaying"
    x-on:mousemove="showControls = true; clearTimeout(hideTimeout); hideTimeout = setTimeout(() => { if (isPlaying) showControls = false; }, 3000)"
>
    <div class="absolute top-3 left-3 flex items-center gap-2 pointer-events-none">
        <div class="bg-cyan-400/20 border border-cyan-400/50 text-cyan-400 text-[10px] font-mono px-1.5 py-0.5 rounded">60 FPS</div>
        <div class="bg-green-400/20 border border-green-400/50 text-green-400 text-[10px] font-mono px-1.5 py-0.5 rounded">LIVE</div>
    </div>

    <video
        x-ref="video"
        x-bind:src="src"
        x-bind:poster="poster"
        x-bind:muted="muted"
        x-bind:loop="loop"
        x-bind:autoplay="autoplay"
        class="w-full h-full object-contain"
        x-on:click="togglePlay()"
        x-on:play="isPlaying = true"
        x-on:pause="isPlaying = false"
        x-on:timeupdate="currentTime = $refs.video.currentTime"
        x-on:loadedmetadata="duration = $refs.video.duration"
        x-on:ended="isPlaying = false"
        playsinline
    ></video>

    <div class="absolute inset-0 flex items-center justify-center bg-black/20 transition-opacity" x-show="!isPlaying" x-cloak x-transition.opacity>
        <button
            type="button"
            class="flex items-center justify-center size-16 rounded-full bg-cyan-400/20 text-cyan-400 hover:bg-cyan-400/30 transition-colors backdrop-blur-sm border border-cyan-400/50"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
        </button>
    </div>

    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent transition-opacity"
         x-show="showControls"
         x-cloak
         x-transition.opacity>
        <div class="flex items-center gap-3 text-white p-3">
            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="togglePlay()" x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'">
                <gsmui:icon.play variant="mini" x-show="!isPlaying" />
                <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            </button>

            <span class="text-xs tabular-nums font-mono text-cyan-400 min-w-[3rem]" x-text="formatTime(currentTime)"></span>

            <div class="flex-1 h-1 bg-zinc-700 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
                <div class="h-full bg-gradient-to-r from-cyan-400 to-green-400 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
            </div>

            <span class="text-xs tabular-nums font-mono text-cyan-400 min-w-[3rem] text-right" x-text="formatTime(duration)"></span>

            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="toggleMute()" x-bind:aria-label="isMuted ? '{{ __('Unmute') }}' : '{{ __('Mute') }}'">
                <gsmui:icon.speaker-x-mark variant="mini" x-show="isMuted" />
                <gsmui:icon.speaker-wave variant="mini" x-show="!isMuted" x-cloak />
            </button>
        </div>
    </div>

    <div class="absolute right-3 bottom-16 w-32 h-20 bg-zinc-800/80 border border-zinc-700 rounded-lg hidden md:block">
        <div class="p-2 text-zinc-400 text-[10px]">Stream Chat</div>
        <div class="px-2 space-y-1">
            <div class="text-[10px] text-zinc-300">Player1: nice!</div>
            <div class="text-[10px] text-zinc-300">GamerX: pog</div>
            <div class="text-[10px] text-zinc-300">Viewer: w play?</div>
        </div>
    </div>
</div>
