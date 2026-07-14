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
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <gsmui:card
                        variant="outlined"
                        class="p-6 {{ ($feature['size'] ?? 'sm') === 'lg' ? 'sm:col-span-2' : '' }}"
                    >
                        @if ($feature['icon'] ?? null)
                            <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="size-8 text-violet-500" />
                        @endif
                        @if ($feature['name'] ?? null)
                            <gsmui:heading size="default" level="3" class="mt-4">{{ $feature['name'] }}</gsmui:heading>
                        @endif
                        @if ($feature['desc'] ?? null)
                            <gsmui:text variant="subtle" class="mt-2">{{ $feature['desc'] }}</gsmui:text>
                        @endif
                    </gsmui:card>
                @endforeach
            </div>
        @endif
    </div>
</div>
