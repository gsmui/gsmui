@props([
    'logo' => __('Acme'),
    'columns' => [
        ['title' => __('Product'), 'links' => [__('Features'), __('Pricing'), __('Integrations'), __('Enterprise'), __('Changelog'), __('Roadmap')]],
        ['title' => __('Solutions'), 'links' => [__('Startups'), __('Enterprise'), __('Education'), __('Nonprofits'), __('Government')]],
        ['title' => __('Resources'), 'links' => [__('Documentation'), __('API'), __('Guides'), __('Blog'), __('Community'), __('Status')]],
        ['title' => __('Company'), 'links' => [__('About'), __('Careers'), __('Press'), __('Partners'), __('Contact')]],
        ['title' => __('Legal'), 'links' => [__('Privacy'), __('Terms'), __('Security'), __('Compliance'), __('Cookie Policy')]],
        ['title' => __('Support'), 'links' => [__('Help Center'), __('Training'), __('Migration'), __('Professional Services')]],
    ],
])

<footer {{ $attributes->class('border-t border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 py-16 px-6') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
            @foreach ($columns as $column)
                <div>
                    <div class="text-xs font-semibold uppercase tracking-wider text-zinc-500">{{ $column['title'] }}</div>
                    <ul class="mt-4 space-y-2">
                        @foreach ($column['links'] as $link)
                            <li><a href="#" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">{{ $link }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="mt-12 border-t border-zinc-200 dark:border-white/10 pt-8 text-center text-sm text-zinc-500">
            &copy; {{ date('Y') }} {{ $logo }}. {{ __('All rights reserved.') }}
        </div>
    </div>
</footer>
