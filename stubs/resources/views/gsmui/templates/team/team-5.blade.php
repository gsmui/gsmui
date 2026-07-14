@props([
    'title' => __('Our team'),
    'featured' => ['name' => 'Sarah Chen', 'role' => 'CEO & Co-founder', 'bio' => __('Sarah has over 15 years of experience building technology companies. Before founding the company, she served as VP of Product at Google, where she led a team of 500+ engineers. She holds a PhD in Computer Science from MIT and is passionate about using technology to solve real-world problems.')],
    'members' => [
        ['name' => 'Marcus Johnson', 'role' => 'CTO'],
        ['name' => 'Emily Rodriguez', 'role' => 'CPO'],
        ['name' => 'David Kim', 'role' => 'CFO'],
        ['name' => 'Priya Patel', 'role' => 'VP Engineering'],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $title }}</h2>
        </div>
        <div class="grid items-center gap-10 lg:grid-cols-2">
            <div class="aspect-[4/5] rounded-2xl bg-zinc-200 dark:bg-white/10"></div>
            <div class="space-y-4">
                <div class="text-sm font-medium text-zinc-500">{{ $featured['role'] }}</div>
                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $featured['name'] }}</h3>
                <p class="text-zinc-600 dark:text-zinc-300">{{ $featured['bio'] }}</p>
            </div>
        </div>
        <div class="mt-16 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($members as $member)
                <div class="text-center">
                    <gsmui:avatar :initials="substr($member['name'], 0, 2)" />
                    <div class="mt-3 font-semibold text-zinc-900 dark:text-white">{{ $member['name'] }}</div>
                    <div class="text-sm text-zinc-500">{{ $member['role'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
