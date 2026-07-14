@props([
    'buttons' => [
        ['label' => 'Explore Gsmui Pro', 'href' => '#', 'style' => 'primary'],
    ],
    'features' => [
        ['desc' => 'Access to cutting-edge design components.'],
        ['desc' => 'Create stunning web experiences in minutes.'],
        ['desc' => 'Built for developers seeking high performance.'],
    ],
])

<div {{ $attributes->class('relative bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-5xl">
                    Transform Your Great<br>Web Presence with <span class="text-blue-600 dark:text-blue-400">Gsmui Pro</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400">
                    Provides innovative tools and components to craft a professional and modern web experience quickly and efficiently.
                </p>
                <div class="mt-8 space-y-4">
                    @foreach ($features as $feature)
                        <div class="flex items-center gap-3">
                            <svg class="size-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ $feature['desc'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-10">
                    @foreach ($buttons as $button)
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-blue-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @endforeach
                </div>
            </div>
            <div class="rounded-2xl border border-zinc-200 dark:border-white/10 bg-zinc-50 dark:bg-zinc-800/50 p-8">
                <svg class="size-8 text-blue-600 dark:text-blue-400 mb-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C9.591 11.69 11 13.166 11 15c0 1.933-1.567 3.5-3.5 3.5-1.271 0-2.404-.672-2.917-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311C19.591 11.69 21 13.166 21 15c0 1.933-1.567 3.5-3.5 3.5-1.271 0-2.404-.672-2.917-1.179z"/></svg>
                <blockquote class="text-lg leading-relaxed text-zinc-700 dark:text-zinc-300">
                    "Gsmui Pro has revolutionized our web design process. The components are incredibly intuitive and have significantly streamlined workflow."
                </blockquote>
                <div class="mt-6 flex items-center gap-3">
                    <div class="size-10 rounded-full bg-zinc-300 dark:bg-zinc-600" aria-hidden="true"></div>
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-white">Alex Rivera</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">CTO, TechStart</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
