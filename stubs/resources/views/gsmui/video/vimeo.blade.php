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
    data-gsmui-video-vimeo
    x-on:mouseenter="showControls = true"
    x-on:mouseleave="showControls = !isPlaying"
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

    <div class="absolute inset-0 flex items-center justify-center bg-black/10 transition-opacity" x-show="!isPlaying" x-cloak x-transition.opacity>
        <button
            type="button"
            class="flex items-center justify-center size-12 rounded-full border-2 border-white/80 text-white hover:bg-white/10 transition-colors"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
        </button>
    </div>

    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent transition-opacity"
         x-show="showControls"
         x-cloak
         x-transition.opacity>
        <div class="flex items-center gap-3 text-white">
            <button type="button" class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity" x-on:click="togglePlay()" x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'">
                <gsmui:icon.play variant="mini" x-show="!isPlaying" />
                <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            </button>

            <span class="text-xs tabular-nums opacity-0 group-hover:opacity-100 transition-opacity" x-text="formatTime(currentTime)"></span>

            <div class="flex-1 h-0.5 bg-white/20 rounded-full overflow-hidden cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity" x-on:click="seek($event)">
                <div class="h-full bg-blue-500 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
            </div>

            <span class="text-xs tabular-nums opacity-0 group-hover:opacity-100 transition-opacity" x-text="formatTime(duration)"></span>
        </div>
    </div>

    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
        <div class="size-8 bg-white/10 rounded flex items-center justify-center text-white text-xs font-medium">V</div>
    </div>
</div>
