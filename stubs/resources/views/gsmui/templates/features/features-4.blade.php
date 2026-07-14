@props([
    'title' => '',
    'subtitle' => '',
    'us' => [],
    'them' => [],
    'features_list' => [],
])

<div {{ $attributes->class('bg-white dark:bg-zinc-900 py-16 sm:py-24') }}>
    <div class="mx-auto max-w-5xl px-6 lg:px-8">
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

        <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-zinc-200 dark:border-white/10">
                        <th class="p-4 text-left text-sm font-semibold text-zinc-900 dark:text-white w-1/3">{{ __('Feature') }}</th>
                        <th class="p-4 text-center text-sm font-semibold text-zinc-900 dark:text-white w-1/3 bg-blue-50 dark:bg-blue-500/10">
                            @if (count($us))
                                <gsmui:text variant="strong" size="sm">{{ $us[0]['name'] ?? '' }}</gsmui:text>
                                <br>
                                <gsmui:text variant="subtle" size="sm">{{ $us[0]['desc'] ?? '' }}</gsmui:text>
                            @endif
                        </th>
                        <th class="p-4 text-center text-sm font-semibold text-zinc-900 dark:text-white w-1/3">
                            @if (count($them))
                                <gsmui:text variant="strong" size="sm">{{ $them[0]['name'] ?? '' }}</gsmui:text>
                                <br>
                                <gsmui:text variant="subtle" size="sm">{{ $them[0]['desc'] ?? '' }}</gsmui:text>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($features_list as $feature)
                        <tr class="border-b border-zinc-100 dark:border-white/5 last:border-0">
                            <td class="p-4 text-sm text-zinc-700 dark:text-zinc-300">{{ $feature['name'] }}</td>
                            <td class="p-4 text-center bg-blue-50/50 dark:bg-blue-500/5">
                                @if ($feature['us_supported'] ?? false)
                                    <gsmui:icon name="check" variant="mini" class="inline size-5 text-emerald-500" />
                                @else
                                    <gsmui:icon name="x-mark" variant="mini" class="inline size-5 text-zinc-300 dark:text-zinc-600" />
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if ($feature['them_supported'] ?? false)
                                    <gsmui:icon name="check" variant="mini" class="inline size-5 text-emerald-500" />
                                @else
                                    <gsmui:icon name="x-mark" variant="mini" class="inline size-5 text-zinc-300 dark:text-zinc-600" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
