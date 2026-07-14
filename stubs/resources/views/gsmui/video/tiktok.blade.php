@blaze(fold: true)

@props([
    'src' => null,
    'poster' => null,
    'autoplay' => false,
    'muted' => false,
    'loop' => false,
])

@php
$classes = Gsmui::classes()
    ->add('relative w-full overflow-hidden rounded-xl bg-black')
    ->add('aspect-[9/16]')
    ->add('max-h-[70vh]')
    ->add('mx-auto')
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
        liked: false,
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
        toggleLike() {
            this.liked = !this.liked;
        },
        seek(event) {
            const video = this.$refs.video;
            const rect = event.currentTarget.getBoundingClientRect();
            const pos = (event.clientX - rect.left) / rect.width;
            video.currentTime = Math.max(0, Math.min(pos * video.duration, video.duration));
        },
        formatTime(time) {
            if (!time || isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
    }"
    {{ $attributes->class($classes) }}
    data-gsmui-video-tiktok
    x-on:click="togglePlay()"
>
    <video
        x-ref="video"
        x-bind:src="src"
        x-bind:poster="poster"
        x-bind:muted="muted"
        x-bind:loop="loop"
        x-bind:autoplay="autoplay"
        class="w-full h-full object-cover"
        x-on:play="isPlaying = true"
        x-on:pause="isPlaying = false"
        x-on:timeupdate="currentTime = $refs.video.currentTime"
        x-on:loadedmetadata="duration = $refs.video.duration"
        x-on:ended="isPlaying = false"
        playsinline
    ></video>

    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-black/60 pointer-events-none"></div>

    <div class="absolute top-4 left-4 right-16 pointer-events-none">
        <div class="text-white text-sm font-medium drop-shadow-md">@username</div>
        <div class="text-white/80 text-xs mt-1 line-clamp-2 drop-shadow-md">{{ $title ?? 'Video description here' }}</div>
        <div class="flex items-center gap-1 text-white/70 text-xs mt-2 drop-shadow-md">
            <gsmui:icon.music variant="mini" />
            <span class="truncate">Original Audio — Trending Sound</span>
        </div>
    </div>

    <div class="absolute right-2 bottom-20 flex flex-col items-center gap-4">
        <div class="flex flex-col items-center gap-1">
            <button type="button" class="flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm" x-on:click.stop="toggleLike()">
                <gsmui:icon.heart variant="mini" x-show="!liked" />
                <gsmui:icon.heart variant="mini" x-show="liked" x-cloak class="text-red-500" />
            </button>
            <span class="text-xs text-white tabular-nums" x-text="liked ? '24.5K' : '24.3K'"></span>
        </div>

        <div class="flex flex-col items-center gap-1">
            <button type="button" class="flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm">
                <gsmui:icon.chat-bubble variant="mini" />
            </button>
            <span class="text-xs text-white tabular-nums">1,204</span>
        </div>

        <div class="flex flex-col items-center gap-1">
            <button type="button" class="flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm">
                <gsmui:icon.share variant="mini" />
            </button>
            <span class="text-xs text-white tabular-nums">Share</span>
        </div>

        <div class="flex flex-col items-center gap-1">
            <button type="button" class="flex items-center justify-center size-10 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors backdrop-blur-sm">
                <gsmui:icon.bookmark variant="mini" />
            </button>
            <span class="text-xs text-white tabular-nums">Save</span>
        </div>
    </div>

    <div class="absolute bottom-3 left-0 right-16">
        <div class="h-0.5 bg-white/20 rounded-full overflow-hidden cursor-pointer" x-on:click.stop="seek($event)">
            <div class="h-full bg-red-500 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
        </div>
        <div class="flex items-center justify-between mt-1">
            <span class="text-xs text-white tabular-nums" x-text="formatTime(currentTime)"></span>
            <span class="text-xs text-white tabular-nums" x-text="formatTime(duration)"></span>
        </div>
    </div>
</div>
