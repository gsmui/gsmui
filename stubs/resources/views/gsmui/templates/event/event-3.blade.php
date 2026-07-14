@props([
    'title' => 'Building Scalable APIs with Laravel',
    'subtitle' => 'Learn best practices for designing, building, and deploying production-ready APIs.',
    'date' => 'October 5, 2026',
    'time' => '2:00 PM EST',
    'speaker' => [
        'name' => 'James Mitchell',
        'role' => 'Senior Backend Engineer, Stripe',
        'bio' => 'James has over 10 years of experience building payment APIs that process billions of dollars. He is a core contributor to Laravel and speaks at conferences worldwide.',
    ],
    'topics' => [
        'RESTful API design principles',
        'Authentication & rate limiting strategies',
        'Database optimization for API workloads',
        'Caching patterns for high-traffic APIs',
        'Testing and monitoring best practices',
    ],
    'registration_url' => '#',
])

<div {{ $attributes->class(['bg-white dark:bg-zinc-900 min-h-screen']) }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <gsmui:brand name="Webinar Series" href="#" />
            <gsmui:button variant="primary" size="sm" icon="video-camera">{{ __('Register Free') }}</gsmui:button>
        </div>
    </header>

    <section class="max-w-4xl mx-auto px-4 py-16">
        <div class="flex flex-wrap gap-2 mb-4">
            <gsmui:badge color="teal" variant="solid" rounded>{{ $date }}</gsmui:badge>
            <gsmui:badge color="cyan" variant="solid" rounded>{{ $time }}</gsmui:badge>
            <gsmui:badge color="green" variant="solid" rounded>{{ __('Free') }}</gsmui:badge>
        </div>
        <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
        <gsmui:text variant="subtle" size="lg" class="mt-3 max-w-2xl">{{ $subtitle }}</gsmui:text>
        <div class="mt-8 flex gap-3">
            <gsmui:button variant="primary" size="default" href="{{ $registration_url }}" icon="video-camera">{{ __('Register Now') }}</gsmui:button>
            <gsmui:button variant="outline" size="default" icon="calendar">{{ __('Add to Calendar') }}</gsmui:button>
        </div>
    </section>

    <gsmui:divider />

    <section class="max-w-4xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <gsmui:heading size="default" level="2" class="mb-4">{{ __('What You\'ll Learn') }}</gsmui:heading>
                <div class="space-y-3">
                    @foreach($topics as $topic)
                        <div class="flex items-start gap-3">
                            <gsmui:icon name="check" variant="mini" class="w-5 h-5 text-teal-500 mt-0.5 shrink-0" />
                            <gsmui:text>{{ $topic }}</gsmui:text>
                        </div>
                    @endforeach
                </div>
            </div>

            <gsmui:card variant="default" class="p-6">
                <gsmui:heading size="default" level="3" class="mb-4">{{ __('About the Speaker') }}</gsmui:heading>
                <div class="flex items-center gap-4 mb-4">
                    <gsmui:avatar name="{{ $speaker['name'] }}" size="lg" circle />
                    <div>
                        <gsmui:text variant="strong">{{ $speaker['name'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $speaker['role'] }}</gsmui:text>
                    </div>
                </div>
                <gsmui:text variant="subtle" size="sm">{{ $speaker['bio'] }}</gsmui:text>
            </gsmui:card>
        </div>
    </section>

    <section class="bg-teal-50 dark:bg-teal-900/20 py-12">
        <div class="max-w-4xl mx-auto px-4">
            <gsmui:heading size="default" level="2" class="text-center mb-6">{{ __('Who Should Attend?') }}</gsmui:heading>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @php
                    $audiences = [
                        ['icon' => 'academic-cap', 'title' => 'Backend Developers', 'desc' => 'Building or maintaining API services'],
                        ['icon' => 'light-bulb', 'title' => 'Full-Stack Engineers', 'desc' => 'Looking to improve API design skills'],
                        ['icon' => 'chart-bar', 'title' => 'Tech Leads', 'desc' => 'Architecting scalable systems'],
                    ];
                @endphp
                @foreach($audiences as $audience)
                    <div class="text-center p-4">
                        <gsmui:icon name="{{ $audience['icon'] }}" variant="outline" class="w-8 h-8 text-teal-500 mx-auto" />
                        <gsmui:text variant="strong" size="sm" class="mt-2">{{ $audience['title'] }}</gsmui:text>
                        <gsmui:text variant="subtle" size="sm">{{ $audience['desc'] }}</gsmui:text>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-12">
        <gsmui:heading size="default" level="2" class="text-center mb-6">{{ __('Key Takeaways') }}</gsmui:heading>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto">
            <gsmui:card variant="default" class="p-5">
                <gsmui:icon name="light-bulb" variant="outline" class="w-6 h-6 text-teal-500" />
                <gsmui:text variant="strong" size="sm" class="mt-2">{{ __('Design Patterns') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm">{{ __('Proven patterns for maintainable API architecture.') }}</gsmui:text>
            </gsmui:card>
            <gsmui:card variant="default" class="p-5">
                <gsmui:icon name="shield-check" variant="outline" class="w-6 h-6 text-teal-500" />
                <gsmui:text variant="strong" size="sm" class="mt-2">{{ __('Security') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm">{{ __('Protect your APIs with industry-standard practices.') }}</gsmui:text>
            </gsmui:card>
            <gsmui:card variant="default" class="p-5">
                <gsmui:icon name="bolt" variant="outline" class="w-6 h-6 text-teal-500" />
                <gsmui:text variant="strong" size="sm" class="mt-2">{{ __('Performance') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm">{{ __('Optimize for speed with caching and query tuning.') }}</gsmui:text>
            </gsmui:card>
            <gsmui:card variant="default" class="p-5">
                <gsmui:icon name="chart-bar" variant="outline" class="w-6 h-6 text-teal-500" />
                <gsmui:text variant="strong" size="sm" class="mt-2">{{ __('Monitoring') }}</gsmui:text>
                <gsmui:text variant="subtle" size="sm">{{ __('Track and measure API health in production.') }}</gsmui:text>
            </gsmui:card>
        </div>
    </section>

    <section class="max-w-4xl mx-auto px-4 py-16 text-center">
        <gsmui:heading size="lg" level="2">{{ __('Don\'t Miss Out') }}</gsmui:heading>
        <gsmui:text variant="subtle" class="mt-2">{{ __('Limited to 500 live attendees. Register now to secure your spot.') }}</gsmui:text>
        <div class="mt-6 max-w-md mx-auto flex gap-2">
            <gsmui:input type="email" placeholder="{{ __('Enter your email') }}" icon="envelope" class="flex-1" />
            <gsmui:button variant="primary">{{ __('Register') }}</gsmui:button>
        </div>
    </section>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ __('Webinar Series. All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
