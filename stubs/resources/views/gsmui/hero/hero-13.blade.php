@props([
    'buttons' => [
        ['label' => 'Book A Discovery Call', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-green-50 to-emerald-50 dark:from-zinc-900 dark:to-zinc-800') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-4 py-1.5 text-sm font-medium text-emerald-700 dark:text-emerald-300">
                <span class="size-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                #1 Frontend Toolkit for Developers
            </div>
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                Build Efficiently with<br>
                <span class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Gsmui Pro</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                Gsmui Pro provides the components you need to create professional websites and applications with ease.
            </p>
            <div class="mt-10">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="rounded-xl bg-emerald-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition-all duration-200">{{ $button['label'] }}</a>
                @endforeach
            </div>
            <p class="mt-8 text-sm text-zinc-400 dark:text-zinc-500">34,585 Projects built with Gsmui Pro last week</p>
        </div>
    </div>
</div>
