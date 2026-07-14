@blaze(fold: true)

@props([
    'src' => null,
    'autoplay' => false,
    'showTitle' => false,
    'title' => null,
    'artist' => null,
])

@php
$classes = Gsmui::classes()
    ->add('w-full max-w-xl')
    ->add('bg-transparent')
    ;
@endphp

<div
    x-data="{
        isPlaying: false,
        currentTime: 0,
        duration: 0,
        progress: 0,
        init() {
            const audio = this.$refs.audio;
            audio.addEventListener('timeupdate', () => {
                this.currentTime = audio.currentTime;
                this.progress = audio.duration ? (audio.currentTime / audio.duration) * 100 : 0;
            });
            audio.addEventListener('loadedmetadata', () => {
                this.duration = audio.duration;
            });
            audio.addEventListener('ended', () => {
                this.isPlaying = false;
            });
        },
        togglePlay() {
            const audio = this.$refs.audio;
            if (this.isPlaying) {
                audio.pause();
            } else {
                audio.play();
            }
            this.isPlaying = !this.isPlaying;
        },
        seek(event) {
            const audio = this.$refs.audio;
            const rect = event.currentTarget.getBoundingClientRect();
            const pos = (event.clientX - rect.left) / rect.width;
            audio.currentTime = Math.max(0, Math.min(pos * audio.duration, audio.duration));
        },
        formatTime(time) {
            if (!time || isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
    }"
    {{ $attributes->class($classes) }}
    data-gsmui-audio-youtube
>
    @if ($showTitle && $title)
        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mb-1 truncate">{{ $title }}</div>
    @endif

    <div class="flex items-center gap-3">
        <button
            type="button"
            class="flex items-center justify-center size-10 rounded-full bg-red-600 text-white shrink-0 hover:bg-red-700 active:bg-red-800 transition-colors"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            <gsmui:icon.play variant="mini" x-show="!isPlaying" />
        </button>

        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10" x-text="formatTime(currentTime)"></span>
                <div class="flex-1 h-1 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
                    <div class="h-full bg-red-600 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
                </div>
                <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10 text-right" x-text="formatTime(duration)"></span>
            </div>
        </div>
    </div>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
