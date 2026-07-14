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
    ->add('relative w-full overflow-hidden bg-black')
    ->add($aspectMap[$aspectRatio] ?? 'aspect-video')
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
    data-gsmui-video-minimal
    x-on:mouseenter="showControls = true; clearTimeout(hideTimeout)"
    x-on:mouseleave="showControls = !isPlaying"
    x-on:mousemove="showControls = true; clearTimeout(hideTimeout); hideTimeout = setTimeout(() => { if (isPlaying) showControls = false; }, 2000)"
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
            class="flex items-center justify-center size-12 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
        </button>
    </div>

    <div class="absolute bottom-0 left-0 right-0 px-4 pb-2 opacity-0 group-hover:opacity-100 transition-opacity"
         x-show="showControls"
         x-cloak>
        <div class="h-px bg-white/20 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
            <div class="h-full bg-white/80 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
        </div>
        <div class="flex items-center justify-end gap-2 mt-1">
            <button type="button" class="text-white/70 hover:text-white transition-colors" x-on:click="toggleMute()" x-bind:aria-label="isMuted ? '{{ __('Unmute') }}' : '{{ __('Mute') }}'">
                <gsmui:icon.speaker-x-mark variant="mini" x-show="isMuted" />
                <gsmui:icon.speaker-wave variant="mini" x-show="!isMuted" x-cloak />
            </button>
        </div>
    </div>
</div>
