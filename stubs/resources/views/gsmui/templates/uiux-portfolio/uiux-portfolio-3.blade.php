@props([
    'title' => 'Liam Torres',
    'subtitle' => 'Design-driven product thinker creating interfaces that bridge beauty and function.',
    'works' => [
        ['title' => 'Music Streaming App', 'category' => 'Mobile', 'size' => 'tall'],
        ['title' => 'SaaS Onboarding', 'category' => 'Web', 'size' => 'short'],
        ['title' => 'Brand Identity System', 'category' => 'Branding', 'size' => 'short'],
        ['title' => 'Real Estate Platform', 'category' => 'Web', 'size' => 'tall'],
        ['title' => 'Fitness Tracker', 'category' => 'Mobile', 'size' => 'short'],
        ['title' => 'AI Writing Tool', 'category' => 'Product', 'size' => 'tall'],
    ],
    'tools' => ['Figma', 'Sketch', 'Adobe XD', 'Framer', 'Miro', 'Notion', 'Principle', 'Lottie', 'Webflow', 'Zeplin'],
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400 md:flex">
                <a href="#works" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Works') }}</a>
                <a href="#tools" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Tools') }}</a>
                <a href="#contact" class="hover:text-zinc-900 dark:hover:text-white transition-colors">{{ __('Contact') }}</a>
            </nav>
            <gsmui:button variant="ghost" size="sm" icon="globe">{{ __('EN') }}</gsmui:button>
        </div>
    </header>

    <main>
        <section class="relative overflow-hidden px-6 py-24 text-center">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-transparent to-sky-50 dark:from-blue-950/30 dark:via-transparent dark:to-sky-950/30"></div>
            <div class="relative mx-auto max-w-3xl">
                <gsmui:heading size="xl" level="1" class="mb-4">{{ $title }}</gsmui:heading>
                <gsmui:text size="lg" variant="subtle">{{ $subtitle }}</gsmui:text>
                <div class="mt-8 flex justify-center gap-3">
                    <gsmui:button variant="primary" href="#works">{{ __('Explore Work') }}</gsmui:button>
                    <gsmui:button variant="outline" href="#contact">{{ __('Say Hello') }}</gsmui:button>
                </div>
            </div>
        </section>

        <section id="works" class="mx-auto max-w-6xl px-6 pb-24">
            <gsmui:heading size="lg" level="2" class="mb-2">{{ __('Featured Works') }}</gsmui:heading>
            <gsmui:text variant="subtle" class="mb-10">{{ __('A mosaic of recent design explorations.') }}</gsmui:text>
            <div class="columns-1 gap-6 sm:columns-2 lg:columns-3">
                @foreach ($works as $work)
                    <div class="mb-6 break-inside-avoid">
                        <gsmui:card variant="interactive" class="group overflow-hidden">
                            <x-slot:image>
                                <div class="flex items-center justify-center bg-gradient-to-br from-blue-100 to-sky-100 dark:from-blue-900/40 dark:to-sky-900/40 {{ $work['size'] === 'tall' ? 'aspect-[3/4]' : 'aspect-[4/3]' }}">
                                    <gsmui:icon name="photo" variant="outline" class="h-10 w-10 text-blue-300 dark:text-blue-500/30" />
                                </div>
                            </x-slot:image>
                            <div class="p-5">
                                <gsmui:text variant="strong">{{ $work['title'] }}</gsmui:text>
                                <gsmui:badge color="blue" class="mt-2">{{ $work['category'] }}</gsmui:badge>
                            </div>
                        </gsmui:card>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="tools" class="border-t border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800/50 px-6 py-24">
            <div class="mx-auto max-w-6xl text-center">
                <gsmui:heading size="lg" level="2" class="mb-2">{{ __('Design Toolkit') }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mb-10">{{ __('Tools I use daily to bring ideas to life.') }}</gsmui:text>
                <div class="flex flex-wrap justify-center gap-3">
                    @foreach ($tools as $tool)
                        <gsmui:badge color="blue" variant="solid" rounded>{{ $tool }}</gsmui:badge>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="px-6 py-24 text-center">
            <div class="mx-auto max-w-xl">
                <gsmui:icon name="sparkles" variant="outline" class="mx-auto mb-4 h-8 w-8 text-blue-500" />
                <gsmui:heading size="lg" level="2">{{ __("Let's work together") }}</gsmui:heading>
                <gsmui:text variant="subtle" class="mt-3">{{ __('I\'m always open to discussing product design work or partnership opportunities.') }}</gsmui:text>
                <gsmui:button variant="primary" class="mt-8" href="mailto:hello@example.com">{{ __('Start a Project') }}</gsmui:button>
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8 text-center text-sm text-zinc-500">
        &copy; {{ date('Y') }} {{ $title }}. {{ __('Designed with care.') }}
    </footer>
</div>
