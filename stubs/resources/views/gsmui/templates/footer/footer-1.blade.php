@props([
    'logo' => __('Acme'),
    'description' => __('Building the future of team collaboration. Empowering teams worldwide since 2020.'),
    'columns' => [
        ['title' => __('Product'), 'links' => [['label' => __('Features'), 'href' => '#'], ['label' => __('Pricing'), 'href' => '#'], ['label' => __('Integrations'), 'href' => '#'], ['label' => __('Changelog'), 'href' => '#']]],
        ['title' => __('Company'), 'links' => [['label' => __('About'), 'href' => '#'], ['label' => __('Blog'), 'href' => '#'], ['label' => __('Careers'), 'href' => '#'], ['label' => __('Press'), 'href' => '#']]],
        ['title' => __('Resources'), 'links' => [['label' => __('Documentation'), 'href' => '#'], ['label' => __('API Reference'), 'href' => '#'], ['label' => __('Guides'), 'href' => '#'], ['label' => __('Support'), 'href' => '#']]],
        ['title' => __('Legal'), 'links' => [['label' => __('Privacy'), 'href' => '#'], ['label' => __('Terms'), 'href' => '#'], ['label' => __('Security'), 'href' => '#']]],
    ],
])

<footer {{ $attributes->class('border-t border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-900 py-16 px-6') }}>
    <div class="mx-auto max-w-7xl">
        <div class="grid gap-10 lg:grid-cols-6">
            <div class="lg:col-span-2">
                <div class="text-lg font-bold text-zinc-900 dark:text-white">{{ $logo }}</div>
                <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400 max-w-xs">{{ $description }}</p>
            </div>
            @foreach ($columns as $column)
                <div>
                    <div class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $column['title'] }}</div>
                    <ul class="mt-4 space-y-3">
                        @foreach ($column['links'] as $link)
                            <li><a href="{{ $link['href'] }}" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">{{ $link['label'] }}</a></li>
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
