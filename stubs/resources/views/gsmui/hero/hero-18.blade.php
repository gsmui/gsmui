@props([
    'buttons' => [
        ['label' => 'Get UI Kit Now', 'href' => '#', 'style' => 'primary'],
        ['label' => 'Check Live Preview', 'href' => '#', 'style' => 'secondary'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">Design Stunning UIs Effortlessly<br>with <span class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-transparent">Gsmui Pro</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">High-quality components and templates, helping you build beautiful websites faster. No complex setup required—just focus on your creativity.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-violet-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-violet-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-zinc-300 dark:border-white/10 px-8 py-3 text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-white/5 transition-all duration-200">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
