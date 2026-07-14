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
    ->add('bg-white dark:bg-zinc-800')
    ->add('border border-zinc-200 dark:border-white/10')
    ->add('rounded-lg p-3 shadow-sm')
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
    data-gsmui-audio-bandcamp
>
    <div class="flex items-center gap-3">
        <div class="flex-1 min-w-0">
            @if ($showTitle && $title)
                <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $title }}</div>
            @endif
            @if ($showTitle && $artist)
                <div class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $artist }}</div>
            @endif
        </div>

        <button
            type="button"
            class="flex items-center justify-center size-8 rounded-full border border-zinc-900 dark:border-white text-zinc-900 dark:text-white shrink-0 hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-zinc-900 active:opacity-70 transition-colors"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            <gsmui:icon.play variant="mini" x-show="!isPlaying" />
        </button>

        <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10 text-right" x-text="formatTime(currentTime)"></span>

        <button
            type="button"
            class="flex items-center gap-1 px-3 py-1.5 rounded-md bg-teal-500 text-white text-xs font-medium hover:bg-teal-600 active:bg-teal-700 transition-colors shrink-0"
        >
            <gsmui:icon.bag-shopping variant="micro" />
            {{ __('Buy') }}
        </button>
    </div>

    <div class="flex items-center gap-2 mt-2">
        <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10" x-text="formatTime(currentTime)"></span>
        <div class="flex-1 h-1.5 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
            <div class="h-full bg-teal-500 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
        </div>
        <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10 text-right" x-text="formatTime(duration)"></span>
    </div>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
