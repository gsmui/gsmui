@props([
    'title' => '',
    'subtitle' => '',
    'plans' => [],
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

        @if ($plans)
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">
                @foreach ($plans as $plan)
                    @php $highlighted = $plan['highlighted'] ?? false; @endphp
                    <gsmui:card
                        variant="outlined"
                        class="p-8 relative {{ $highlighted ? 'border-blue-500 dark:border-blue-400 shadow-lg ring-1 ring-blue-500/20 dark:ring-blue-400/20' : '' }}"
                    >
                        @if ($highlighted)
                            <gsmui:badge color="blue" variant="solid" rounded class="absolute -top-3 left-1/2 -translate-x-1/2">{{ __('Most Popular') }}</gsmui:badge>
                        @endif
                        @if ($plan['name'] ?? null)
                            <gsmui:heading size="default" level="3">{{ $plan['name'] }}</gsmui:heading>
                        @endif
                        @if ($plan['desc'] ?? null)
                            <gsmui:text variant="subtle" size="sm" class="mt-1">{{ $plan['desc'] }}</gsmui:text>
                        @endif
                        <div class="mt-6 flex items-baseline gap-1">
                            @if ($plan['price'] ?? null)
                                <gsmui:heading size="xl" level="4" class="tabular-nums">{{ $plan['price'] }}</gsmui:heading>
                            @endif
                            @if ($plan['period'] ?? null)
                                <gsmui:text variant="subtle" size="sm">/{{ $plan['period'] }}</gsmui:text>
                            @endif
                        </div>
                        @if ($plan['features'] ?? null)
                            <ul class="mt-8 space-y-3">
                                @foreach ($plan['features'] as $feature)
                                    <li class="flex items-center gap-3">
                                        @if ($feature['included'] ?? true)
                                            <gsmui:icon name="check" variant="mini" class="size-4 text-emerald-500 flex-none" />
                                        @else
                                            <gsmui:icon name="x-mark" variant="mini" class="size-4 text-zinc-300 dark:text-zinc-600 flex-none" />
                                        @endif
                                        <gsmui:text variant="subtle" size="sm" class="{{ ($feature['included'] ?? true) ? '' : 'line-through text-zinc-400 dark:text-zinc-500' }}">{{ $feature['text'] }}</gsmui:text>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="mt-8">
                            <gsmui:button
                                variant="{{ $highlighted ? 'primary' : 'outline' }}"
                                size="default"
                                class="w-full"
                            >{{ $plan['cta_text'] ?? __('Get started') }}</gsmui:button>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        @endif
    </div>
</div>
