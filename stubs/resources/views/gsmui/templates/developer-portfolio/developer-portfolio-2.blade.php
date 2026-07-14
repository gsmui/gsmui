@props([
    'title' => 'Jordan Rivera',
    'subtitle' => 'Frontend Engineer & UI Architect',
    'avatar_name' => 'Jordan Rivera',
    'stats' => [
        ['label' => 'Projects', 'value' => '47', 'icon' => 'folder'],
        ['label' => 'Stars', 'value' => '2.8k', 'icon' => 'star'],
        ['label' => 'Contributors', 'value' => '126', 'icon' => 'users'],
        ['label' => 'Commits', 'value' => '5.2k', 'icon' => 'code-bracket'],
    ],
    'repos' => [
        ['name' => 'design-system', 'desc' => 'A comprehensive component library with accessibility-first design tokens.', 'lang' => 'TypeScript', 'stars' => 892],
        ['name' => 'data-viz-engine', 'desc' => 'High-performance charting library for real-time streaming data.', 'lang' => 'JavaScript', 'stars' => 534],
        ['name' => 'form-builder', 'desc' => 'Drag-and-drop form builder with validation and conditional logic.', 'lang' => 'Vue', 'stars' => 321],
        ['name' => 'theme-studio', 'desc' => 'Visual theme editor for Tailwind CSS with live preview.', 'lang' => 'React', 'stars' => 445],
    ],
])

<div {{ $attributes->class('min-h-screen bg-white dark:bg-zinc-950') }}>
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <gsmui:brand :name="$title" href="#" />
            <nav class="hidden items-center gap-1 sm:flex">
                <gsmui:button variant="ghost" href="#repos" size="sm">{{ __('Repositories') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#about" size="sm">{{ __('About') }}</gsmui:button>
                <gsmui:button variant="ghost" href="#contact" size="sm">{{ __('Contact') }}</gsmui:button>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 lg:flex lg:gap-12">
        <aside class="mb-10 lg:mb-0 lg:w-80 lg:shrink-0">
            <div class="sticky top-24 space-y-6">
                <div class="flex flex-col items-center text-center">
                    <gsmui:avatar :name="$avatar_name" size="xl" circle />
                    <gsmui:heading size="lg" level="1" class="mt-4">{{ $title }}</gsmui:heading>
                    <gsmui:text variant="subtle" class="mt-1">{{ $subtitle }}</gsmui:text>
                    <gsmui:button variant="outline" size="sm" class="mt-4" icon="envelope">{{ __('Contact') }}</gsmui:button>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($stats as $stat)
                        <gsmui:card variant="outlined" size="sm">
                            <div class="p-4 text-center">
                                <gsmui:icon :name="$stat['icon']" variant="outline" class="mx-auto mb-2 text-blue-500" />
                                <gsmui:text variant="strong" size="lg">{{ $stat['value'] }}</gsmui:text>
                                <gsmui:text variant="subtle" size="sm">{{ __($stat['label']) }}</gsmui:text>
                            </div>
                        </gsmui:card>
                    @endforeach
                </div>
            </div>
        </aside>

        <section id="repos" class="flex-1">
            <gsmui:heading size="lg" level="2" class="mb-6">{{ __('Recent Repositories') }}</gsmui:heading>
            <div class="space-y-4">
                @foreach ($repos as $repo)
                    <gsmui:card variant="interactive">
                        <div class="p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <gsmui:heading level="3">{{ $repo['name'] }}</gsmui:heading>
                                    <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $repo['desc'] }}</p>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center gap-3">
                                @php
                                    $langColors = [
                                        'TypeScript' => 'blue',
                                        'JavaScript' => 'amber',
                                        'Vue' => 'emerald',
                                        'React' => 'cyan',
                                    ];
                                @endphp
                                <gsmui:badge :color="$langColors[$repo['lang']] ?? 'zinc'" rounded size="sm">{{ $repo['lang'] }}</gsmui:badge>
                                <span class="flex items-center gap-1 text-sm text-zinc-500">
                                    <gsmui:icon name="star" variant="mini" />{{ $repo['stars'] }}
                                </span>
                            </div>
                        </div>
                    </gsmui:card>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-zinc-200 dark:border-white/10 py-8">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6">
            <gsmui:text variant="subtle" size="sm">&copy; {{ date('Y') }} {{ $title }}</gsmui:text>
            <div class="flex gap-4">
                <gsmui:icon name="code-bracket" class="text-zinc-400 hover:text-blue-500 transition-colors cursor-pointer" />
                <gsmui:icon name="globe" class="text-zinc-400 hover:text-blue-500 transition-colors cursor-pointer" />
                <gsmui:icon name="envelope" class="text-zinc-400 hover:text-blue-500 transition-colors cursor-pointer" />
            </div>
        </div>
    </footer>
</div>
