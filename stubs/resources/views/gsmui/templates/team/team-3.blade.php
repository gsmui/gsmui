@props([
    'title' => __('Our structure'),
    'ceo' => ['name' => 'Sarah Chen', 'role' => 'CEO'],
    'vps' => [
        ['name' => 'Marcus Johnson', 'role' => 'CTO'],
        ['name' => 'Emily Rodriguez', 'role' => 'CPO'],
        ['name' => 'David Kim', 'role' => 'CFO'],
    ],
    'leads' => [
        ['name' => 'Alex Okafor', 'role' => 'Eng Lead', 'vp' => 0],
        ['name' => 'Priya Patel', 'role' => 'Infra Lead', 'vp' => 0],
        ['name' => 'Tom Nakamura', 'role' => 'Design Lead', 'vp' => 1],
        ['name' => 'Lisa Fernández', 'role' => 'Product Lead', 'vp' => 1],
        ['name' => 'James Wright', 'role' => 'Finance Lead', 'vp' => 2],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="flex flex-col items-center gap-8">
            <div class="text-center">
                <gsmui:avatar :initials="substr($ceo['name'], 0, 2)" size="lg" />
                <div class="mt-2 font-semibold text-zinc-900 dark:text-white">{{ $ceo['name'] }}</div>
                <div class="text-xs text-zinc-500">{{ $ceo['role'] }}</div>
            </div>
            <div class="h-8 w-0.5 bg-zinc-200 dark:bg-white/10"></div>
            <div class="grid gap-8 sm:grid-cols-3">
                @foreach ($vps as $vp)
                    <div class="text-center">
                        <gsmui:avatar :initials="substr($vp['name'], 0, 2)" />
                        <div class="mt-2 font-semibold text-zinc-900 dark:text-white">{{ $vp['name'] }}</div>
                        <div class="text-xs text-zinc-500">{{ $vp['role'] }}</div>
                        <div class="mt-4 space-y-4">
                            @foreach ($leads as $lead)
                                @if ($lead['vp'] === $loop->parent->index)
                                    <div class="rounded-lg border border-zinc-200 dark:border-white/10 px-3 py-2">
                                        <div class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ $lead['name'] }}</div>
                                        <div class="text-xs text-zinc-500">{{ $lead['role'] }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
