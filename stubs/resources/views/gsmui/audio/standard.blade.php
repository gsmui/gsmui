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
    ->add('flex items-center gap-3 w-full max-w-xl')
    ->add('bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-white/10 rounded-xl p-3 shadow-sm')
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
    data-gsmui-audio-standard
>
    <button
        type="button"
        class="flex items-center justify-center size-10 rounded-full bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shrink-0 hover:opacity-80 active:opacity-70 transition-opacity"
        x-on:click="togglePlay()"
        x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
    >
        <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
        <gsmui:icon.play variant="mini" x-show="!isPlaying" />
    </button>

    <div class="flex-1 min-w-0 flex flex-col gap-1">
        @if ($showTitle && $title)
            <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $title }}</div>
        @endif
        @if ($showTitle && $artist)
            <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $artist }}</div>
        @endif

        <div class="flex items-center gap-2">
            <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10" x-text="formatTime(currentTime)"></span>
            <div class="flex-1 h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
                <div class="h-full bg-zinc-900 dark:bg-white rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
            </div>
            <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10 text-right" x-text="formatTime(duration)"></span>
        </div>
    </div>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
