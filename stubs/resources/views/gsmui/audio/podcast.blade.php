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
    ->add('rounded-xl p-4 shadow-sm')
    ;
@endphp

<div
    x-data="{
        isPlaying: false,
        playbackRate: 1,
        currentTime: 0,
        duration: 0,
        progress: 0,
        rates: [1, 1.25, 1.5, 2],
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
        skip(seconds) {
            const audio = this.$refs.audio;
            audio.currentTime = Math.max(0, Math.min(audio.currentTime + seconds, audio.duration));
        },
        setRate(rate) {
            this.playbackRate = rate;
            this.$refs.audio.playbackRate = rate;
        },
        formatTime(time) {
            if (!time || isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds.toString().padStart(2, '0')}`;
        },
    }"
    {{ $attributes->class($classes) }}
    data-gsmui-audio-podcast
>
    @if ($showTitle && $title)
        <div class="text-base font-semibold text-zinc-900 dark:text-zinc-100 mb-1">{{ $title }}</div>
    @endif
    @if ($showTitle && $artist)
        <div class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ $artist }}</div>
    @endif

    <div class="flex items-center gap-2 mb-3">
        <button
            type="button"
            class="flex items-center justify-center size-10 rounded-full bg-amber-500 text-white shrink-0 hover:bg-amber-600 active:bg-amber-700 transition-colors"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            <gsmui:icon.play variant="mini" x-show="!isPlaying" />
        </button>

        <button
            type="button"
            class="flex items-center justify-center size-8 rounded-full border border-zinc-200 dark:border-white/10 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
            x-on:click="skip(-15)"
            aria-label="{{ __('Rewind 15 seconds') }}"
        >
            <gsmui:icon.skip-back variant="mini" />
        </button>

        <button
            type="button"
            class="flex items-center justify-center size-8 rounded-full border border-zinc-200 dark:border-white/10 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
            x-on:click="skip(15)"
            aria-label="{{ __('Forward 15 seconds') }}"
        >
            <gsmui:icon.skip-forward variant="mini" />
        </button>
    </div>

    <div class="flex items-center gap-2 mb-3">
        <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10" x-text="formatTime(currentTime)"></span>
        <div class="flex-1 h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
            <div class="h-full bg-amber-500 rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
        </div>
        <span class="text-xs text-zinc-500 dark:text-zinc-400 tabular-nums w-10 text-right" x-text="formatTime(duration)"></span>
    </div>

    <div class="flex items-center gap-1">
        @foreach ([1, 1.25, 1.5, 2] as $rate)
            <button
                type="button"
                class="px-2 py-0.5 rounded text-xs font-medium transition-colors"
                :class="playbackRate == {{ $rate }} ? 'bg-amber-500 text-white' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-600'"
                x-on:click="setRate({{ $rate }})"
            >
                {{ $rate }}x
            </button>
        @endforeach
    </div>

    <audio x-ref="audio" x-bind:src="src" x-bind:playbackRate="playbackRate" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
