@blaze(fold: true)

@props([
    'src' => null,
    'autoplay' => false,
    'showTitle' => false,
    'title' => null,
    'artist' => null,
])

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
    {{ $attributes->class('inline-flex items-center gap-1 text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors cursor-pointer select-none') }}
    data-gsmui-audio-minimal
    x-on:click="togglePlay()"
    role="button"
    tabindex="0"
    x-on:keydown.enter="togglePlay()"
    x-on:keydown.space.prevent="togglePlay()"
>
    <span x-show="!isPlaying" x-cloak>
        <gsmui:icon.play variant="micro" class="inline-block me-1" />
        <span x-text="'{{ $title ?? __('Audio') }}'"></span>
        @if ($artist)
            <span class="text-zinc-400 dark:text-zinc-500"> — {{ $artist }}</span>
        @endif
    </span>
    <span x-show="isPlaying" x-cloak>
        <gsmui:icon.pause variant="micro" class="inline-block me-1" />
        <span x-text="'{{ $title ?? __('Audio') }}'"></span>
        @if ($artist)
            <span class="text-zinc-400 dark:text-zinc-500"> — {{ $artist }}</span>
        @endif
    </span>

    <audio x-ref="audio" x-bind:src="src" class="hidden" x-on:timeupdate="currentTime = $refs.audio.currentTime; progress = $refs.audio.duration ? ($refs.audio.currentTime / $refs.audio.duration) * 100 : 0" x-on:loadedmetadata="duration = $refs.audio.duration" x-on:ended="isPlaying = false"></audio>
</div>
