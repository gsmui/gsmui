@props([
    'title' => '',
    'subtitle' => '',
    'items' => [],
    'cta_text' => '',
])

<div {{ $attributes->class('bg-white dark:bg-zinc-900 py-16 sm:py-24') }}>
    <div class="mx-auto max-w-3xl px-6 lg:px-8">
        @if ($title || $subtitle)
            <div class="mx-auto max-w-2xl text-center mb-12">
                @if ($title)
                    <gsmui:heading size="xl" level="2">{{ $title }}</gsmui:heading>
                @endif
                @if ($subtitle)
                    <gsmui:text variant="subtle" size="lg" class="mt-4">{{ $subtitle }}</gsmui:text>
                @endif
            </div>
        @endif

        @if ($items)
            <div class="space-y-4 mb-10">
                @foreach ($items as $item)
                    <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-zinc-50 dark:hover:bg-white/5 transition-colors">
                        <div class="flex-none flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-500/20">
                            @if ($item['icon'] ?? null)
                                <gsmui:icon name="{{ $item['icon'] }}" variant="mini" class="size-3.5 text-emerald-600 dark:text-emerald-400" />
                            @else
                                <gsmui:icon name="check" variant="mini" class="size-3.5 text-emerald-600 dark:text-emerald-400" />
                            @endif
                        </div>
                        <gsmui:text variant="strong">{{ $item['text'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($cta_text)
            <div class="text-center">
                <gsmui:button variant="primary" size="default">{{ $cta_text }}</gsmui:button>
            </div>
        @endif
    </div>
</div>
