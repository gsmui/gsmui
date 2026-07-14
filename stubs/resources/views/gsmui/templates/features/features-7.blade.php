@props([
    'title' => '',
    'subtitle' => '',
    'steps' => [],
])

<div {{ $attributes->class('bg-white dark:bg-zinc-900 py-16 sm:py-24') }}>
    <div class="mx-auto max-w-3xl px-6 lg:px-8">
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

        @if ($steps)
            <div class="relative">
                <div class="absolute left-6 top-6 bottom-6 w-px bg-zinc-200 dark:bg-white/10"></div>
                <div class="space-y-12">
                    @foreach ($steps as $step)
                        <div class="relative flex gap-6">
                            <div class="flex-none flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 font-bold text-sm relative z-10">
                                {{ $step['number'] ?? $loop->iteration }}
                            </div>
                            <div class="pt-2">
                                @if ($step['title'] ?? null)
                                    <gsmui:heading size="default" level="3">{{ $step['title'] }}</gsmui:heading>
                                @endif
                                @if ($step['desc'] ?? null)
                                    <gsmui:text variant="subtle" class="mt-2">{{ $step['desc'] }}</gsmui:text>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
