@props([
    'buttons' => [
        ['label' => 'Join for free', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">A hub for <span class="text-blue-600 dark:text-blue-400">innovative minds</span></h1>
            <p class="mt-4 text-lg text-zinc-500">Connect & Innovate with Gsmui Pro</p>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">Accelerate your growth with expert insights and cutting-edge tools. Join a thriving community of innovators.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all">{{ $button['label'] }}</a>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-zinc-400">Already part of Gsmui Pro? <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Log in</a></p>
        </div>
    </div>
</div>
