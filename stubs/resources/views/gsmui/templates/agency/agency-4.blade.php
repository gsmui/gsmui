@props([
    'title' => __('Simple Solutions, Powerful Results'),
    'subtitle' => __('We focus on what matters most — delivering clarity and impact.'),
    'services' => [
        ['number' => '01', 'name' => 'Discovery', 'desc' => 'We learn about your business, audience, and goals to build a solid foundation.'],
        ['number' => '02', 'name' => 'Strategy', 'desc' => 'A clear roadmap with prioritized initiatives aligned to your objectives.'],
        ['number' => '03', 'name' => 'Design', 'desc' => 'Thoughtful, user-centered interfaces that communicate your brand.'],
        ['number' => '04', 'name' => 'Development', 'desc' => 'Clean, performant code built with modern best practices.'],
        ['number' => '05', 'name' => 'Launch', 'desc' => 'Careful deployment with monitoring and support to ensure success.'],
    ],
    'testimonial' => [
        'quote' => 'Working with this team transformed our digital presence. They stripped away complexity and delivered exactly what our users needed.',
        'author' => 'Alexandra Reed',
        'role' => 'VP of Product, Streamline',
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-900') }}>
    <header class="border-b border-zinc-100 dark:border-white/5">
        <div class="mx-auto max-w-5xl px-6 py-4 flex items-center justify-between">
            <gsmui:brand name="Clarity" href="/" />
            <gsmui:button variant="subtle" size="sm">{{ __('Get in Touch') }}</gsmui:button>
        </div>
    </header>

    <section class="mx-auto max-w-3xl px-6 py-32 text-center">
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-5 max-w-xl mx-auto">{{ $subtitle }}</gsmui:text>
        <div class="mt-10 flex justify-center gap-4">
            <gsmui:button variant="primary" size="default">{{ __('Start a Project') }}</gsmui:button>
            <gsmui:button variant="ghost" size="default">{{ __('See Our Process') }}</gsmui:button>
        </div>
    </section>

    <gsmui:divider />

    <section class="mx-auto max-w-3xl px-6 py-24">
        <div class="space-y-12">
            @foreach ($services as $service)
                <div class="flex gap-8">
                    <gsmui:text variant="subtle" size="xl" class="font-mono text-zinc-300 dark:text-zinc-700 shrink-0 w-12">{{ $service['number'] }}</gsmui:text>
                    <div>
                        <gsmui:heading size="default" level="3">{{ $service['name'] }}</gsmui:heading>
                        <gsmui:text variant="subtle" class="mt-2">{{ $service['desc'] }}</gsmui:text>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <gsmui:divider />

    <section class="mx-auto max-w-3xl px-6 py-24">
        <gsmui:card variant="flat" size="lg">
            <div class="p-10 text-center">
                <gsmui:text size="lg" class="italic leading-relaxed">&ldquo;{{ $testimonial['quote'] }}&rdquo;</gsmui:text>
                <gsmui:divider class="my-6" />
                <gsmui:text variant="strong" size="sm">{{ $testimonial['author'] }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm">{{ $testimonial['role'] }}</gsmui:text>
            </div>
        </gsmui:card>
    </section>

    <section class="mx-auto max-w-3xl px-6 py-24 text-center">
        <gsmui:heading size="lg" level="2">{{ __('Ready to Get Started?') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-3">{{ __('One conversation is all it takes.') }}</gsmui:text>
        <gsmui:button variant="primary" size="default" class="mt-8">{{ __('Schedule a Call') }}</gsmui:button>
    </section>

    <footer class="border-t border-zinc-100 dark:border-white/5 py-12">
        <div class="mx-auto max-w-5xl px-6 flex flex-col md:flex-row items-center justify-between gap-6">
            <gsmui:brand name="Clarity" href="/" />
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} Clarity Agency. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
