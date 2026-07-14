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
            <div class="space-y-16 lg:space-y-24">
                @foreach ($features as $feature)
                    <div class="flex flex-col gap-8 lg:flex-row lg:items-center {{ $loop->odd ? '' : 'lg:flex-row-reverse' }}">
                        <div class="flex-1">
                            <div class="h-64 sm:h-80 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-zinc-800 dark:to-zinc-700"></div>
                        </div>
                        <div class="flex-1 space-y-4">
                            @if ($feature['icon'] ?? null)
                                <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="size-8 text-blue-500" />
                            @endif
                            @if ($feature['name'] ?? null)
                                <gsmui:heading size="lg" level="3">{{ $feature['name'] }}</gsmui:heading>
                            @endif
                            @if ($feature['badge'] ?? null)
                                <gsmui:badge color="blue" variant="solid" rounded>{{ $feature['badge'] }}</gsmui:badge>
                            @endif
                            @if ($feature['desc'] ?? null)
                                <gsmui:text variant="subtle" size="lg">{{ $feature['desc'] }}</gsmui:text>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
