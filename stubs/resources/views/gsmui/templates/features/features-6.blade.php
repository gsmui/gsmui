@props([
    'title' => '',
    'subtitle' => '',
    'features' => [],
])

<div {{ $attributes->class('bg-white dark:bg-zinc-900 py-16 sm:py-24') }}>
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        @if ($title || $subtitle)
            <div class="mx-auto max-w-2xl text-center mb-16">
                @if ($title)
                    <gsmui:heading size="xl" level="2">{{ $title }}</gsmui:heading>
                @endif
                @if ($subtitle)
                    <gsmui:text variant="subtle" size="lg" class="mt-4">{{ $subtitle }}</gsmui:text>
                @endif
            </div>
        @endif

        @if ($features)
            <div class="flex gap-6 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-thin">
                @foreach ($features as $feature)
                    @php
                        $color = $feature['color'] ?? 'blue';
                        $colorMap = [
                            'blue' => 'from-blue-500 to-blue-600',
                            'green' => 'from-emerald-500 to-emerald-600',
                            'violet' => 'from-violet-500 to-violet-600',
                            'amber' => 'from-amber-500 to-amber-600',
                            'rose' => 'from-rose-500 to-rose-600',
                            'cyan' => 'from-cyan-500 to-cyan-600',
                        ];
                        $gradient = $colorMap[$color] ?? $colorMap['blue'];
                    @endphp
                    <div class="min-w-[280px] sm:min-w-[320px] snap-start flex-shrink-0">
                        <gsmui:card variant="outlined" class="p-6 h-full relative overflow-hidden">
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r {{ $gradient }}"></div>
                            @if ($feature['icon'] ?? null)
                                <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="size-8 text-{{ $color }}-500" />
                            @endif
                            @if ($feature['name'] ?? null)
                                <gsmui:heading size="default" level="3" class="mt-4">{{ $feature['name'] }}</gsmui:heading>
                            @endif
                            @if ($feature['desc'] ?? null)
                                <gsmui:text variant="subtle" class="mt-2">{{ $feature['desc'] }}</gsmui:text>
                            @endif
                        </gsmui:card>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
