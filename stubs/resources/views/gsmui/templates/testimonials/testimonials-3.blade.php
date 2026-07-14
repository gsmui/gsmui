@props([
    'testimonials' => [
        ['quote' => __('The onboarding was seamless. Our team was up and running in less than a day.'), 'name' => 'Anna Lee', 'role' => 'Head of Ops, Buildr'],
        ['quote' => __('I\'ve tried dozens of tools. This one actually delivers on its promises. The automation alone saves us 10 hours a week.'), 'name' => 'James Wright', 'role' => 'Engineering Manager, DataFlow'],
        ['quote' => __('Game changer.'), 'name' => 'Priya Patel', 'role' => 'Founder, LaunchKit'],
        ['quote' => __('The analytics dashboard gives us visibility we never had before. Decisions are faster and more data-driven now.'), 'name' => 'Tom Nakamura', 'role' => 'VP Product, MetricsHQ'],
        ['quote' => __('Support team is incredible. Every ticket resolved within hours, not days.'), 'name' => 'Lisa Fernández', 'role' => 'CTO, CloudSync'],
        ['quote' => __('We migrated our entire workflow in a weekend. Zero downtime, zero issues.'), 'name' => 'Alex Okafor', 'role' => 'Lead Dev, ShipFast'],
    ],
])

<section {{ $attributes->class('py-20 px-6 bg-white dark:bg-zinc-900') }}>
    <div class="mx-auto max-w-5xl">
        <div class="columns-1 gap-6 space-y-6 md:columns-2">
            @foreach ($testimonials as $t)
                <div class="break-inside-avoid rounded-2xl border border-zinc-200 dark:border-white/10 p-6">
                    <blockquote class="text-sm text-zinc-600 dark:text-zinc-300">"{{ $t['quote'] }}"</blockquote>
                    <div class="mt-4 flex items-center gap-3">
                        <gsmui:avatar :initials="substr($t['name'], 0, 2)" size="sm" />
                        <div>
                            <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $t['name'] }}</div>
                            <div class="text-xs text-zinc-500">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
