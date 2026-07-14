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
    ->add('w-full max-w-md')
    ->add('bg-green-600 dark:bg-green-700')
    ->add('rounded-full p-2 shadow-md')
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
    data-gsmui-audio-voice
>
    <div class="flex items-center gap-3 px-2">
        <button
            type="button"
            class="flex items-center justify-center size-10 rounded-full bg-white/20 text-white hover:bg-white/30 active:bg-white/40 transition-colors shrink-0"
            x-on:click="togglePlay()"
            x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
        >
            <gsmui:icon.pause variant="mini" x-show="isPlaying" x-cloak />
            <gsmui:icon.play variant="mini" x-show="!isPlaying" />
        </button>

        <div class="flex-1 h-8 flex items-center">
            <div class="w-full h-1 bg-white/20 rounded-full overflow-hidden cursor-pointer" x-on:click="seek($event)">
                <div class="h-full bg-white rounded-full transition-all duration-150" x-bind:style="`width: ${progress}%`"></div>
            </div>
        </div>

        <span class="text-xs text-white tabular-nums shrink-0" x-text="formatTime(duration)"></span>
    </div>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
