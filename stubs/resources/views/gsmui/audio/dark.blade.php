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
    ->add('bg-zinc-900 dark:bg-black')
    ->add('rounded-xl p-4 shadow-lg')
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
    data-gsmui-audio-dark
>
    <div class="flex items-center gap-4">
        <button
            type="button"
            class="flex items-center justify-center size-12 rounded-full border-2 border-white/30 text-white hover:bg-white/10 active:bg-white/20 transition-colors"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.pause variant="lg" x-show="isPlaying" x-cloak />
            <gsmui:icon.play variant="lg" x-show="!isPlaying" />
        </button>

        <div class="flex-1 min-w-0">
            @if ($showTitle && $title)
                <div class="text-sm font-medium text-white truncate">{{ $title }}</div>
            @endif
            @if ($showTitle && $artist)
                <div class="text-xs text-white/60 truncate">{{ $artist }}</div>
            @endif
        </div>

        <span class="text-xs text-white/60 tabular-nums" x-text="formatTime(currentTime)"></span>
        <span class="text-xs text-white/40 tabular-nums" x-text="formatTime(duration)"></span>
    </div>

    <div class="mt-3 h-1 bg-white/10 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
        <div class="h-full bg-white rounded-full transition-all duration-150 shadow-[0_0_8px_rgba(255,255,255,0.5)]" x-bind:style="`width: ${progress}%`"></div>
    </div>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
