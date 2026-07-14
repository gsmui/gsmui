@props([
    'title' => __('Our leadership'),
    'members' => [
        ['name' => 'Sarah Chen', 'role' => 'CEO', 'twitter' => '#', 'linkedin' => '#'],
        ['name' => 'Marcus Johnson', 'role' => 'CTO', 'twitter' => '#', 'linkedin' => '#'],
        ['name' => 'Emily Rodriguez', 'role' => 'CPO', 'twitter' => '#', 'linkedin' => '#'],
        ['name' => 'David Kim', 'role' => 'CFO', 'twitter' => '#', 'linkedin' => '#'],
        ['name' => 'Lisa Park', 'role' => 'VP Sales', 'twitter' => '#', 'linkedin' => '#'],
    ],
])

<section {{ $attributes->class('py-20 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl px-6">
        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white mb-12">{{ $title }}</h2>
    </div>
    <div class="flex snap-x snap-mandatory gap-6 overflow-x-auto px-6 pb-4">
        @foreach ($members as $member)
            <div class="w-64 shrink-0 snap-start text-center">
                <gsmui:avatar :initials="substr($member['name'], 0, 2)" size="xl" />
                <div class="mt-4 font-semibold text-zinc-900 dark:text-white">{{ $member['name'] }}</div>
                <div class="text-sm text-zinc-500">{{ $member['role'] }}</div>
                <div class="mt-3 flex justify-center gap-3">
                    <a href="{{ $member['twitter'] }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="Twitter">
                        <x-gsmui:icon name="at-symbol" class="h-4 w-4" />
                    </a>
                    <a href="{{ $member['linkedin'] }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="LinkedIn">
                        <x-gsmui:icon name="globe-alt" class="h-4 w-4" />
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</section>
