@props([
    'buttons' => [
        ['label' => 'Get Started', 'href' => '#', 'style' => 'primary'],
        ['label' => 'View Changelog', 'href' => '#', 'style' => 'secondary'],
    ],
    'stats' => [
        ['value' => '50+', 'label' => 'Components'],
        ['value' => '10k+', 'label' => 'Downloads'],
        ['value' => '99%', 'label' => 'Satisfaction'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-blue-50 dark:bg-blue-900/30 px-4 py-1.5 text-sm font-medium text-blue-700 dark:text-blue-300"><span aria-hidden="true">🎉</span> Introducing Gsmui Pro v2.0</div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Build Beautiful<br><span class="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">User Interfaces</span><br>with Gsmui Pro</h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">A modern component library built with Laravel Livewire, Tailwind CSS. Create stunning interfaces with minimal effort.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="mt-12 flex items-center justify-center gap-12">
                @foreach ($stats as $stat)
                    <div><p class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p><p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['label'] }}</p></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
