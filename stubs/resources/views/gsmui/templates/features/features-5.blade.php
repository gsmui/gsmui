@props([
    'title' => '',
    'subtitle' => '',
    'tabs' => [],
])

<div {{ $attributes->class('bg-white dark:bg-zinc-900 py-16 sm:py-24') }} x-data="{ activeTab: 0 }">
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

        @if ($tabs)
            <div class="flex flex-wrap justify-center gap-2 mb-12">
                @foreach ($tabs as $tab)
                    <button
                        type="button"
                        @click="activeTab = {{ $loop->index }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-colors"
                        :class="activeTab === {{ $loop->index }}
                            ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-400'
                            : 'text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300'"
                    >
                        @if ($tab['icon'] ?? null)
                            <gsmui:icon name="{{ $tab['icon'] }}" variant="outline" class="size-4" />
                        @endif
                        {{ $tab['name'] }}
                    </button>
                @endforeach
            </div>

            @foreach ($tabs as $tab)
                <div x-show="activeTab === {{ $loop->index }}" x-cloak>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($tab['features'] ?? [] as $feature)
                            <gsmui:card variant="outlined" class="p-6">
                                @if ($feature['icon'] ?? null)
                                    <gsmui:icon name="{{ $feature['icon'] }}" variant="outline" class="size-6 text-blue-500" />
                                @endif
                                @if ($feature['name'] ?? null)
                                    <gsmui:heading size="default" level="3" class="mt-3">{{ $feature['name'] }}</gsmui:heading>
                                @endif
                                @if ($feature['desc'] ?? null)
                                    <gsmui:text variant="subtle" class="mt-2">{{ $feature['desc'] }}</gsmui:text>
                                @endif
                            </gsmui:card>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
