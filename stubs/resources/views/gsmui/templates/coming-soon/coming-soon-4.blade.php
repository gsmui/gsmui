@props([
    'title' => 'Under Maintenance',
    'message' => 'We\'re performing scheduled maintenance to improve your experience. We\'ll be back shortly.',
    'estimated_time' => '2 hours',
    'contact_email' => 'support@example.com',
])

<div {{ $attributes->class(['min-h-screen bg-zinc-50 dark:bg-zinc-900 flex flex-col']) }}>
    <header class="border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-center">
            <gsmui:brand name="{{ __('Maintenance') }}" href="#" />
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center">
        <div class="max-w-lg mx-auto px-4 text-center py-16">
            <div class="w-20 h-20 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mx-auto mb-8">
                <gsmui:icon name="bolt" variant="outline" class="w-10 h-10 text-amber-500" />
            </div>

            <gsmui:heading size="xl" level="1">{{ $title }}</gsmui:heading>
            <gsmui:text variant="subtle" size="lg" class="mt-4 max-w-md mx-auto">{{ $message }}</gsmui:text>

            <div class="mt-8 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-zinc-100 dark:bg-zinc-800">
                <gsmui:icon name="clock" variant="outline" class="w-4 h-4 text-zinc-500" />
                <gsmui:text variant="subtle" size="sm">{{ __('Estimated time: ') }}{{ $estimated_time }}</gsmui:text>
            </div>

            <gsmui:divider class="my-8" />

            <gsmui:text variant="subtle" size="sm">{{ __('While you wait, here\'s what we\'re improving:') }}</gsmui:text>
            <div class="mt-4 space-y-3 max-w-xs mx-auto text-left">
                <div class="flex items-center gap-3">
                    <gsmui:icon name="check" variant="mini" class="w-4 h-4 text-amber-500 shrink-0" />
                    <gsmui:text size="sm">{{ __('Performance optimizations') }}</gsmui:text>
                </div>
                <div class="flex items-center gap-3">
                    <gsmui:icon name="check" variant="mini" class="w-4 h-4 text-amber-500 shrink-0" />
                    <gsmui:text size="sm">{{ __('Security enhancements') }}</gsmui:text>
                </div>
                <div class="flex items-center gap-3">
                    <gsmui:icon name="check" variant="mini" class="w-4 h-4 text-amber-500 shrink-0" />
                    <gsmui:text size="sm">{{ __('New features deployment') }}</gsmui:text>
                </div>
                <div class="flex items-center gap-3">
                    <gsmui:icon name="check" variant="mini" class="w-4 h-4 text-amber-500 shrink-0" />
                    <gsmui:text size="sm">{{ __('Database maintenance') }}</gsmui:text>
                </div>
            </div>

            <gsmui:divider class="my-8" />

            <gsmui:text variant="subtle" size="sm">{{ __('Current status:') }}</gsmui:text>
            <div class="mt-3 max-w-xs mx-auto space-y-2 text-left">
                <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                    <gsmui:text size="sm">{{ __('Web servers') }}</gsmui:text>
                    <gsmui:badge color="amber" rounded>{{ __('Maintenance') }}</gsmui:badge>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                    <gsmui:text size="sm">{{ __('Database') }}</gsmui:text>
                    <gsmui:badge color="amber" rounded>{{ __('Upgrading') }}</gsmui:badge>
                </div>
                <div class="flex items-center justify-between p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800">
                    <gsmui:text size="sm">{{ __('API') }}</gsmui:text>
                    <gsmui:badge color="amber" rounded>{{ __('Offline') }}</gsmui:badge>
                </div>
            </div>

            <gsmui:divider class="my-8" />

            <gsmui:text variant="subtle" size="sm">{{ __('Need help? Contact us at') }}</gsmui:text>
            <gsmui:button variant="ghost" size="sm" href="mailto:{{ $contact_email }}" icon="envelope">{{ $contact_email }}</gsmui:button>

            <div class="mt-8 flex justify-center gap-3">
                <gsmui:button variant="ghost" size="sm" class="text-zinc-400">
                    <gsmui:icon name="globe" variant="outline" class="w-5 h-5" />
                </gsmui:button>
                <gsmui:button variant="ghost" size="sm" class="text-zinc-400">
                    <gsmui:icon name="chat-bubble-left-right" variant="outline" class="w-5 h-5" />
                </gsmui:button>
            </div>
        </div>
    </main>

    <footer class="border-t border-zinc-200 dark:border-zinc-800 py-6">
        <div class="max-w-lg mx-auto px-4 text-center">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ __('All rights reserved.') }}</gsmui:text>
        </div>
    </footer>
</div>
