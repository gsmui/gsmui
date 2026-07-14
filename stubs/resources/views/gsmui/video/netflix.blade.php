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
        skip(seconds) {
            this.$refs.video.currentTime = Math.max(0, Math.min(this.$refs.video.currentTime + seconds, this.duration));
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
    data-gsmui-video-netflix
    x-on:mouseenter="showControls = true; clearTimeout(hideTimeout)"
    x-on:mouseleave="showControls = !isPlaying"
    x-on:mousemove="showControls = true; clearTimeout(hideTimeout); hideTimeout = setTimeout(() => { if (isPlaying) showControls = false; }, 4000)"
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

    <div class="absolute inset-0 flex items-center justify-center bg-black/20 transition-opacity" x-show="!isPlaying" x-cloak x-transition.opacity>
        <button
            type="button"
            class="flex items-center justify-center size-16 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
        </button>
    </div>

    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent transition-opacity"
         x-show="showControls"
         x-cloak
         x-transition.opacity>
        <div class="flex items-center gap-3 text-white p-3">
            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="skip(-10)" aria-label="{{ __('Rewind 10 seconds') }}">
                <gsmui:icon.skip-back variant="mini" />
            </button>

            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="togglePlay()" x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'">
                <gsmui:icon.play variant="mini" x-show="!isPlaying" />
                <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            </button>

            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="skip(10)" aria-label="{{ __('Forward 10 seconds') }}">
                <gsmui:icon.skip-forward variant="mini" />
            </button>

            <span class="text-xs tabular-nums min-w-[3rem]" x-text="formatTime(currentTime)"></span>

            <div class="flex-1 h-1 bg-white/20 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
                <div class="h-full bg-white rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
            </div>

            <span class="text-xs tabular-nums min-w-[3rem] text-right" x-text="formatTime(duration)"></span>

            <button type="button" class="shrink-0 hover:scale-110 transition-transform" x-on:click="toggleMute()" x-bind:aria-label="isMuted ? '{{ __('Unmute') }}' : '{{ __('Mute') }}'">
                <gsmui:icon.speaker-x-mark variant="mini" x-show="isMuted" />
                <gsmui:icon.speaker-wave variant="mini" x-show="!isMuted" x-cloak />
            </button>
        </div>
    </div>
</div>
