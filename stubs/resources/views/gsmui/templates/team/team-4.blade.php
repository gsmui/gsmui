@props([
    'title' => __('Meet the team'),
    'subtitle' => __('The talented people behind our success.'),
    'members' => [
        ['name' => 'Sarah Chen', 'role' => 'CEO & Co-founder', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
        ['name' => 'Marcus Johnson', 'role' => 'CTO', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
        ['name' => 'Emily Rodriguez', 'role' => 'Head of Design', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
        ['name' => 'David Kim', 'role' => 'VP Engineering', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
        ['name' => 'Priya Patel', 'role' => 'VP Product', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
        ['name' => 'Alex Okafor', 'role' => 'Lead Developer', 'twitter' => '#', 'linkedin' => '#', 'github' => '#'],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
            <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">{{ $subtitle }}</p>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($members as $member)
                <div class="text-center rounded-2xl border border-zinc-200 dark:border-white/10 p-8">
                    <gsmui:avatar :initials="substr($member['name'], 0, 2)" size="lg" />
                    <div class="mt-4 font-semibold text-zinc-900 dark:text-white">{{ $member['name'] }}</div>
                    <div class="text-sm text-zinc-500">{{ $member['role'] }}</div>
                    <div class="mt-4 flex justify-center gap-3">
                        <a href="{{ $member['twitter'] }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="Twitter">
                            <x-gsmui:icon name="at-symbol" class="h-5 w-5" />
                        </a>
                        <a href="{{ $member['linkedin'] }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="LinkedIn">
                            <x-gsmui:icon name="globe-alt" class="h-5 w-5" />
                        </a>
                        <a href="{{ $member['github'] }}" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" aria-label="GitHub">
                            <x-gsmui:icon name="code-bracket" class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
