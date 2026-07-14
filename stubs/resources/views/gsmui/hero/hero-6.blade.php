@props([
    'buttons' => [
        ['label' => 'Get Started', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-blue-50 dark:bg-blue-900/30 px-4 py-1.5 text-sm text-blue-700 dark:text-blue-300">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/></svg>
                Elevate Coding
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl">
                Elevate Coding<br>
                with <span class="bg-gradient-to-r from-blue-600 to-violet-600 bg-clip-text text-transparent">AuraUI</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                Discover components that bring design consistency and ease to your Next.js projects. Build faster with ready-to-use designs.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}"
                       @class([
                           'rounded-xl px-8 py-3 text-sm font-semibold transition-all duration-200',
                           'inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-sm hover:from-blue-500 hover:to-violet-500' => $button['style'] === 'primary',
                       ])>
                        {{ $button['label'] }}
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
