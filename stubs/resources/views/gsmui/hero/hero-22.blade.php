@props([
    'buttons' => [
        ['label' => 'Get Access to 4,958 Resources', 'href' => '#', 'style' => 'primary'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-teal-600 to-emerald-700 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">100x your<br><span class="text-teal-200">development speed</span></h1>
            <p class="mt-6 text-lg leading-8 text-teal-100">Quality Resources Shared by Gsmui Pro</p>
            <p class="mt-4 text-teal-200">Discover the power of Gsmui Pro with our curated collection of developer tools and community insights.</p>
            <div class="mt-10">
                @foreach ($buttons as $button)
                    <a href="{{ $button['href'] }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-8 py-3 text-sm font-semibold text-teal-700 hover:bg-teal-50 transition-all">
                        {{ $button['label'] }}
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
