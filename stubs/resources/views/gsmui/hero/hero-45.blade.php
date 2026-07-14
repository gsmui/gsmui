@props([
    'buttons' => [
        ['label' => 'Start a Project', 'href' => '#', 'style' => 'primary'],
        ['label' => 'View Our Work', 'href' => '#', 'style' => 'secondary'],
    ],
    'stats' => [
        ['value' => '200+', 'label' => 'Projects'],
        ['value' => '50+', 'label' => 'Clients'],
        ['value' => '8+', 'label' => 'Years'],
        ['value' => '15', 'label' => 'Awards'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-slate-50 to-gray-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">We build<br><span class="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">digital experiences</span></h1>
            <p class="mx-auto mt-6 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">A creative agency specializing in web design, development, and digital strategy.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-zinc-900 dark:bg-white px-8 py-3 text-sm font-semibold text-white dark:text-zinc-900 hover:bg-zinc-700 dark:hover:bg-zinc-100 transition-all">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="mt-16 grid grid-cols-2 sm:grid-cols-4 gap-8 text-center">
                @foreach ($stats as $stat)
                    <div><p class="text-4xl font-bold text-zinc-900 dark:text-white">{{ $stat['value'] }}</p><p class="text-sm text-zinc-500">{{ $stat['label'] }}</p></div>
                @endforeach
            </div>
        </div>
    </div>
</div>
