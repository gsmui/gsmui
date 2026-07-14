@props([
    'buttons' => [
        ['label' => 'Get Your Ticket', 'href' => '#', 'style' => 'primary'],
        ['label' => 'View Schedule', 'href' => '#', 'style' => 'secondary'],
    ],
    'stats' => [
        ['value' => '20+', 'label' => 'Speakers'],
        ['value' => '1,000+', 'label' => 'Attendees'],
        ['value' => '2', 'label' => 'Days'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-rose-100 dark:bg-rose-900/30 px-4 py-1.5 text-sm font-medium text-rose-700 dark:text-rose-300"><span aria-hidden="true">🎪</span> Coming June 2026</div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">Gsmui Pro<br><span class="bg-gradient-to-r from-rose-600 to-purple-600 bg-clip-text text-transparent">Conference 2026</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Join developers, designers, and industry leaders for two days of talks, workshops, and networking.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-rose-600 px-8 py-3 text-sm font-semibold text-white hover:bg-rose-500 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="mt-12 grid grid-cols-3 gap-6">
                @foreach ($stats as $stat)
                    <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 p-4"><p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p><p class="text-sm text-zinc-500">{{ $stat['label'] }}</p></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
