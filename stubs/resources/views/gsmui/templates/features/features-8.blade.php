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

        <div class="h-64 sm:h-96 rounded-2xl bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100 dark:from-zinc-800 dark:via-zinc-800 dark:to-zinc-700 mb-12"></div>

        @if ($features)
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="flex gap-4">
                        @if ($feature['icon'] ?? null)
                            <div class="flex-none">
                                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/20">
                                    <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="size-5 text-blue-600 dark:text-blue-400" />
                                </div>
                            </div>
                        @endif
                        <div>
                            @if ($feature['name'] ?? null)
                                <gsmui:text variant="strong" size="sm">{{ $feature['name'] }}</gsmui:text>
                            @endif
                            @if ($feature['desc'] ?? null)
                                <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $feature['desc'] }}</gsmui:text>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
