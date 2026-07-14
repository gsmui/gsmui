@props([
    'title' => '',
    'subtitle' => '',
    'comparisons' => [],
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

        @if ($comparisons)
            <div class="space-y-8">
                @foreach ($comparisons as $comparison)
                    <div>
                        @if ($comparison['label'] ?? null)
                            <gsmui:heading size="default" level="3" class="mb-4 text-center">{{ $comparison['label'] }}</gsmui:heading>
                        @endif
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <gsmui:card variant="outlined" class="p-6 bg-red-50/50 dark:bg-red-500/5 border-red-200 dark:border-red-500/20">
                                <div class="flex items-start gap-3">
                                    <div class="flex-none flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-500/20">
                                        <gsmui:icon name="x-mark" variant="mini" class="size-4 text-red-600 dark:text-red-400" />
                                    </div>
                                    <div>
                                        <gsmui:text variant="strong" size="sm" class="text-red-700 dark:text-red-400">{{ __('Before') }}</gsmui:text>
                                        <gsmui:text variant="subtle" class="mt-1">{{ $comparison['before_text'] ?? '' }}</gsmui:text>
                                    </div>
                                </div>
                            </gsmui:card>
                            <gsmui:card variant="outlined" class="p-6 bg-emerald-50/50 dark:bg-emerald-500/5 border-emerald-200 dark:border-emerald-500/20">
                                <div class="flex items-start gap-3">
                                    <div class="flex-none flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-500/20">
                                        @if ($comparison['icon'] ?? null)
                                            <gsmui:icon name="{{ $comparison['icon'] }}" variant="mini" class="size-4 text-emerald-600 dark:text-emerald-400" />
                                        @else
                                            <gsmui:icon name="check" variant="mini" class="size-4 text-emerald-600 dark:text-emerald-400" />
                                        @endif
                                    </div>
                                    <div>
                                        <gsmui:text variant="strong" size="sm" class="text-emerald-700 dark:text-emerald-400">{{ __('After') }}</gsmui:text>
                                        <gsmui:text variant="subtle" class="mt-1">{{ $comparison['after_text'] ?? '' }}</gsmui:text>
                                    </div>
                                </div>
                            </gsmui:card>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
