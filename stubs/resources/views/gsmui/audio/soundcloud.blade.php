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
    data-gsmui-audio-soundcloud
>
    <div class="relative h-12 bg-zinc-100 dark:bg-zinc-800 rounded-lg overflow-hidden">
        <div class="absolute inset-0 flex items-end gap-px px-1 pb-1">
            @php
                $heights = [40, 65, 50, 80, 45, 90, 55, 70, 35, 85, 60, 75, 42, 95, 58, 68, 38, 82, 52, 78];
            @endphp
            @foreach (array_slice($heights, 0, 20) as $h)
                <div class="flex-1 bg-zinc-300 dark:bg-zinc-600 rounded-sm" style="height: {{ $h }}%"></div>
            @endforeach
        </div>
        <div class="absolute inset-0 bg-orange-500/20 pointer-events-none" x-bind:style="`width: ${progress}%`"></div>
        <div class="absolute top-2 left-2">
            <button
                type="button"
                class="flex items-center justify-center size-6 rounded-full bg-orange-500 text-white hover:bg-orange-600 active:bg-orange-700 transition-colors"
                x-on:click="togglePlay()"
                x-bind:aria-label="isPlaying ? '{{ __('Pause') }}' : '{{ __('Play') }}'"
            >
                <gsmui:icon.pause variant="micro" x-show="isPlaying" x-cloak />
                <gsmui:icon.play variant="micro" x-show="!isPlaying" />
            </button>
        </div>
    </div>

    @if ($showTitle && $title)
        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100 mt-2 truncate">{{ $title }}</div>
    @endif

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
