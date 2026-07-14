@props([
    'stats' => [
        ['value' => '50k+', 'label' => 'Contributors'],
        ['value' => '100k+', 'label' => 'Stars'],
        ['value' => '25k+', 'label' => 'Discussions'],
        ['value' => '∞', 'label' => 'Support'],
    ],
    'contributors' => [
        'Alex · Maintainer', 'Sarah · Core Dev', 'Mike · Designer',
        'Emma · Community', 'John · Docs', 'Lisa · Testing',
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-gray-900 to-zinc-900 text-white') }}>
    <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm text-zinc-300">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>
                Open Source & Free Forever
            </div>
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl">Built by <span class="bg-gradient-to-r from-blue-400 to-violet-400 bg-clip-text text-transparent">Community</span><br>for Everyone</h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">Join thousands of developers, designers, and creators building the future together. Open source, collaborative, and completely free.</p>
            <div class="mt-10 flex items-center justify-center gap-8">
                @foreach ($stats as $stat)
                    <div><p class="text-3xl font-bold text-blue-400">{{ $stat['value'] }}</p><p class="text-xs text-zinc-400">{{ $stat['label'] }}</p></div>
                @endforeach
            </div>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                @foreach ($contributors as $contributor)
                    <span class="rounded-full bg-white/10 px-4 py-2 text-sm">{{ $contributor }}</span>
                @endforeach
            </div>
            <p class="mt-6 text-sm text-zinc-500 italic">"The best projects are built by passionate communities"</p>
            <div class="mt-8 flex items-center justify-center gap-4 text-sm">
                <a href="#" class="rounded-xl bg-white px-6 py-2.5 text-sm font-semibold text-zinc-900 hover:bg-zinc-100 transition-all">Join our Discord</a>
                <span class="text-zinc-500">·</span>
                <a href="#" class="text-zinc-400 hover:text-white transition-all">Follow us on Twitter</a>
                <span class="text-zinc-500">·</span>
                <a href="#" class="text-zinc-400 hover:text-white transition-all">Star us on GitHub</a>
            </div>
        </div>
    </div>
</div>
