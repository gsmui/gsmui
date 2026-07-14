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
    ->add('relative w-full overflow-hidden rounded-xl bg-black')
    ->add($aspectMap[$aspectRatio] ?? 'aspect-video')
    ->add('group')
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
        isFullscreen: false,
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
        toggleFullscreen() {
            if (!document.fullscreenElement) {
                this.$el.requestFullscreen?.();
                this.isFullscreen = true;
            } else {
                document.exitFullscreen?.();
                this.isFullscreen = false;
            }
        },
        formatTime(time) {
            if (!time || isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
    }"
    {{ $attributes->class($classes) }}
    data-gsmui-video-cinema
    x-on:mouseenter="showControls = true; clearTimeout(hideTimeout)"
    x-on:mouseleave="showControls = !isPlaying"
    x-on:mousemove="showControls = true; clearTimeout(hideTimeout); hideTimeout = setTimeout(() => { if (isPlaying) showControls = false; }, 3000)"
>
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

    <div class="absolute inset-0 flex items-center justify-center transition-opacity" x-show="!isPlaying" x-cloak x-transition.opacity>
        <button
            type="button"
            class="flex items-center justify-center size-14 rounded-full bg-white/5 text-white hover:bg-white/10 transition-colors backdrop-blur-sm border border-white/10"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
        </button>
    </div>

    <div class="absolute bottom-0 left-0 right-0 transition-opacity"
         x-show="showControls"
         x-cloak
         x-transition.opacity>
        <div class="h-px bg-white/10 px-3 cursor-pointer" x-on:click="seek($event)">
            <div class="h-full bg-white transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
        </div>
        <div class="flex items-center justify-between px-3 py-2 bg-black/40 backdrop-blur-sm">
            <div class="flex items-center gap-3 text-white">
                <button type="button" class="shrink-0" x-on:click="togglePlay()" x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'">
                    <gsmui:icon.play variant="mini" x-show="!isPlaying" />
                    <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
                </button>

                <span class="text-xs tabular-nums text-white/70" x-text="formatTime(currentTime)"></span>
                <span class="text-xs tabular-nums text-white/40" x-text="formatTime(duration)"></span>
            </div>

            <div class="flex items-center gap-2">
                <div class="flex items-center gap-1 text-white/70">
                    <button type="button" class="hover:text-white transition-colors" x-on:click="toggleMute()" x-bind:aria-label="isMuted ? '{{ __('Unmute') }}' : '{{ __('Mute') }}'">
                        <gsmui:icon.speaker-x-mark variant="mini" x-show="isMuted" />
                        <gsmui:icon.speaker-wave variant="mini" x-show="!isMuted" x-cloak />
                    </button>
                    <div class="w-12 h-1 bg-white/20 rounded-full overflow-hidden cursor-pointer" x-on:click="event => { const r = event.currentTarget.getBoundingClientRect(); const v = (event.clientX - r.left) / r.width; this.$refs.video.volume = Math.max(0, Math.min(v, 1)); }">
                        <div class="h-full bg-white rounded-full transition-all" x-bind:style="`width: ${($refs.video?.volume ?? 1) * 100}%`"></div>
                    </div>
                </div>

                <button type="button" class="shrink-0" x-on:click="toggleFullscreen()" aria-label="{{ __('Fullscreen') }}">
                    <gsmui:icon.arrows-pointing-in variant="mini" x-show="!isFullscreen" />
                    <gsmui:icon.arrows-pointing-out variant="mini" x-show="isFullscreen" x-cloak />
                </button>
            </div>
        </div>
    </div>
</div>
