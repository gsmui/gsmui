@props([
    'title' => 'Minimal Studio',
    'subtitle' => 'Crafting beautiful digital experiences. Coming soon.',
    'social_links' => [
        ['platform' => 'Twitter', 'url' => '#', 'icon' => 'globe'],
        ['platform' => 'Instagram', 'url' => '#', 'icon' => 'photo'],
        ['platform' => 'LinkedIn', 'url' => '#', 'icon' => 'user'],
        ['platform' => 'Email', 'url' => '#', 'icon' => 'envelope'],
    ],
])

<div {{ $attributes->class(['min-h-screen bg-white dark:bg-zinc-900 flex flex-col']) }}>
    <header class="max-w-2xl mx-auto px-4 py-6 w-full flex items-center justify-between">
        <gsmui:brand name="{{ $title }}" href="#" />
        <gsmui:text variant="subtle" size="sm">{{ __('Coming Soon') }}</gsmui:text>
    </header>

    <main class="flex-1 flex items-center justify-center">
        <div class="max-w-2xl mx-auto px-4 text-center py-16">
            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-md mx-auto">{{ $subtitle }}</gsmui:text>

            <div class="mt-10 max-w-sm mx-auto flex gap-2">
                <gsmui:input type="email" placeholder="{{ __('Your email address') }}" icon="envelope" class="flex-1" />
                <gsmui:button variant="primary">{{ __('Notify') }}</gsmui:button>
            </div>
            <gsmui:text variant="subtle" size="sm" class="mt-3">{{ __('We\'ll let you know when we launch.') }}</gsmui:text>

            <gsmui:divider class="my-10" />

            <gsmui:heading size="default" level="3" class="mb-6">{{ __('What We\'re Building') }}</gsmui:heading>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-left max-w-lg mx-auto">
                <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                    <gsmui:icon name="sparkles" variant="outline" class="w-5 h-5 text-zinc-500" />
                    <gsmui:text variant="strong" size="sm" class="mt-1">{{ __('Design') }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm">{{ __('Pixel-perfect interfaces.') }}</gsmui:text>
                </div>
                <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                    <gsmui:icon name="bolt" variant="outline" class="w-5 h-5 text-zinc-500" />
                    <gsmui:text variant="strong" size="sm" class="mt-1">{{ __('Speed') }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm">{{ __('Blazing fast performance.') }}</gsmui:text>
                </div>
                <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800">
                    <gsmui:icon name="shield-check" variant="outline" class="w-5 h-5 text-zinc-500" />
                    <gsmui:text variant="strong" size="sm" class="mt-1">{{ __('Security') }}</gsmui:text>
                    <gsmui:text variant="subtle" size="sm">{{ __('Enterprise-grade protection.') }}</gsmui:text>
                </div>
            </div>

            <gsmui:divider class="my-10" />

            <gsmui:heading size="default" level="3" class="mb-4">{{ __('Our Timeline') }}</gsmui:heading>
            <div class="max-w-sm mx-auto space-y-3 text-left mb-10">
                <div class="flex items-center gap-3">
                    <gsmui:badge color="green" variant="solid" rounded>{{ __('Done') }}</gsmui:badge>
                    <gsmui:text size="sm">{{ __('Concept & research') }}</gsmui:text>
                </div>
                <div class="flex items-center gap-3">
                    <gsmui:badge color="blue" variant="solid" rounded>{{ __('Active') }}</gsmui:badge>
                    <gsmui:text size="sm">{{ __('Design & development') }}</gsmui:text>
                </div>
                <div class="flex items-center gap-3">
                    <gsmui:badge color="zinc" rounded>{{ __('Next') }}</gsmui:badge>
                    <gsmui:text size="sm">{{ __('Beta testing & launch') }}</gsmui:text>
                </div>
            </div>

            <gsmui:divider class="my-10" />

            <gsmui:text variant="subtle" size="sm" class="mb-4">{{ __('Follow us for updates') }}</gsmui:text>
            <div class="flex justify-center gap-3">
                @foreach($social_links as $link)
                    <gsmui:button variant="outline" size="sm" href="{{ $link['url'] }}" class="w-10 h-10 p-0 flex items-center justify-center">
                        <gsmui:icon name="{{ $link['icon'] }}" variant="outline" class="w-5 h-5" />
                    </gsmui:button>
                @endforeach
            </div>

            <gsmui:text variant="subtle" size="sm" class="mt-12">{{ __('Stay tuned for something special.') }}</gsmui:text>
        </div>
    </main>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-8">
        <div class="max-w-2xl mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}. {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
