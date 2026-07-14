@props([
    'buttons' => [
        ['label' => 'Browse All Heroes', 'href' => '#', 'style' => 'primary'],
        ['label' => 'View on GitHub', 'href' => '#', 'style' => 'secondary'],
    ],
    'features' => [
        ['emoji' => '🎨', 'title' => 'Varied Styles', 'desc' => 'From minimal to bold'],
        ['emoji' => '🌓', 'title' => 'Dark Mode', 'desc' => 'Every hero included'],
        ['emoji' => '📱', 'title' => 'Responsive', 'desc' => 'Mobile-first design'],
    ],
])

<div {{ $attributes->class('relative bg-gradient-to-br from-zinc-900 to-slate-900 text-white') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-blue-500/10 via-transparent to-transparent" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <div class="mb-8 inline-flex items-center gap-2 rounded-full bg-blue-500/10 border border-blue-500/20 px-4 py-1.5 text-sm text-blue-300"><span aria-hidden="true">✨</span> Introducing Gsmui Pro 50</div>
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">50 Hero<br><span class="bg-gradient-to-r from-blue-400 via-violet-400 to-purple-400 bg-clip-text text-transparent">Components</span></h1>
            <p class="mt-6 text-lg leading-8 text-zinc-400">A complete collection of production-ready hero sections. Each one is fully responsive, dark-mode compatible, and built with Tailwind CSS.</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                @foreach ($buttons as $button)
                    @if ($button['style'] === 'primary')
                        <a href="{{ $button['href'] }}" class="rounded-xl bg-gradient-to-r from-blue-600 to-violet-600 px-8 py-3 text-sm font-semibold text-white shadow-sm hover:from-blue-500 hover:to-violet-500 transition-all duration-200">{{ $button['label'] }}</a>
                    @else
                        <a href="{{ $button['href'] }}" class="rounded-xl border border-white/10 px-8 py-3 text-sm font-semibold text-zinc-300 hover:bg-white/5 transition-all duration-200">{{ $button['label'] }}</a>
                    @endif
                @endforeach
            </div>
            <div class="mt-16 grid grid-cols-3 gap-4">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-white/10 bg-white/5 p-4 text-left">
                        <span class="text-2xl" aria-hidden="true">{{ $feature['emoji'] }}</span>
                        <p class="mt-2 font-medium">{{ $feature['title'] }}</p>
                        <p class="text-xs text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-8 text-sm text-zinc-500">Gsmui Pro Hero Collection · Free to use · MIT License</p>
        </div>
    </div>
</div>
