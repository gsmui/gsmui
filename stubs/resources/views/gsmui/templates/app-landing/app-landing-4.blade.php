@props([
    'title' => __('The future of creative tools'),
    'subtitle' => __('Unleash your imagination with AI-powered design, video, and audio tools in one app.'),
    'features' => [
        ['icon' => 'photo', 'name' => __('AI Image Generation'), 'desc' => __('Create stunning visuals from text descriptions in seconds.')],
        ['icon' => 'play', 'name' => __('Video Editing'), 'desc' => __('Professional-grade editing with AI-assisted cuts and transitions.')],
        ['icon' => 'pencil', 'name' => __('Smart Design'), 'desc' => __('Auto-layout, color suggestions, and responsive design made easy.')],
        ['icon' => 'sparkles', 'name' => __('Magic Enhance'), 'desc' => __('One-click enhancement for photos, audio, and video content.')],
        ['icon' => 'globe', 'name' => __('Publish Anywhere'), 'desc' => __('Export to any format and publish directly to social platforms.')],
        ['icon' => 'users', 'name' => __('Team Workspace'), 'desc' => __('Real-time collaboration with shared assets and brand kits.')],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-950 text-white relative overflow-hidden') }}>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-cyan-900/20 via-zinc-950 to-zinc-950"></div>

    <header class="relative z-50 sticky top-0 border-b border-white/10 bg-zinc-950/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
            <gsmui:brand name="CreateApp" href="/" />
            <div class="flex items-center gap-3">
                <gsmui:button variant="ghost" size="sm" href="#">{{ __('Sign In') }}</gsmui:button>
                <gsmui:button variant="primary" size="sm" href="#">{{ __('Get Started') }}</gsmui:button>
            </div>
        </div>
    </header>

    <section class="relative z-10 px-6 py-28 text-center">
        <div class="mx-auto max-w-3xl">
            <gsmui:badge color="cyan" rounded class="mb-6">{{ __('Now with AI v3') }}</gsmui:badge>
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl bg-gradient-to-r from-cyan-400 via-green-400 to-emerald-400 bg-clip-text text-transparent">{{ $title }}</h1>
            <p class="mt-6 text-lg text-zinc-400">{{ $subtitle }}</p>
            <div class="mt-10 flex items-center justify-center gap-4">
                <gsmui:button variant="primary" href="#">{{ __('Start Creating Free') }}</gsmui:button>
                <gsmui:button variant="outline" href="#">{{ __('View Gallery') }}</gsmui:button>
            </div>
        </div>
    </section>

    <section class="relative z-10 px-6 pb-20">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-2xl border border-white/10 bg-gradient-to-b from-white/5 to-white/0 p-8 flex items-center justify-center h-72 relative">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-cyan-500/10 via-green-500/10 to-emerald-500/10"></div>
                <div class="relative text-center">
                    <gsmui:icon name="computer-desktop" class="mx-auto h-16 w-16 text-cyan-500/30" />
                    <p class="mt-4 text-sm text-zinc-500">{{ __('App interface preview') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="relative z-10 px-6 py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-16 text-center">
                <h2 class="text-3xl font-bold">{{ __('Powerful creative tools') }}</h2>
                <p class="mt-4 text-zinc-400">{{ __('Everything you need to create, edit, and publish.') }}</p>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($features as $feature)
                    <div class="rounded-xl border border-white/10 bg-white/5 p-6 hover:border-cyan-500/30 transition-colors">
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-cyan-500/10">
                            <gsmui:icon :name="$feature['icon']" class="h-5 w-5 text-cyan-400" />
                        </div>
                        <h3 class="font-semibold">{{ $feature['name'] }}</h3>
                        <p class="mt-2 text-sm text-zinc-400">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative z-10 px-6 py-16 border-t border-white/10">
        <div class="mx-auto max-w-5xl grid grid-cols-2 gap-8 lg:grid-cols-4">
            @foreach ([
                ['value' => '2M+', 'label' => __('Creators')],
                ['value' => '50M+', 'label' => __('Projects Made')],
                ['value' => '150+', 'label' => __('Countries')],
                ['value' => '4.8★', 'label' => __('App Rating')],
            ] as $stat)
                <div class="text-center">
                    <p class="text-3xl font-bold text-cyan-400 tabular-nums">{{ $stat['value'] }}</p>
                    <p class="mt-2 text-sm text-zinc-500">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="relative z-10 px-6 py-20 text-center">
        <div class="mx-auto max-w-2xl">
            <h2 class="text-3xl font-bold">{{ __('Ready to create?') }}</h2>
            <p class="mt-4 text-zinc-400">{{ __('Start for free. Upgrade when you need more power.') }}</p>
            <div class="mt-8">
                <gsmui:button variant="primary" href="#">{{ __('Get Started Free') }}</gsmui:button>
            </div>
        </div>
    </section>

    <footer class="relative z-10 border-t border-white/10 px-6 py-12">
        <div class="mx-auto max-w-6xl flex flex-col items-center gap-6 sm:flex-row sm:justify-between">
            <gsmui:brand name="CreateApp" href="/" />
            <p class="text-sm text-zinc-600">&copy; {{ date('Y') }} {{ __('CreateApp. All rights reserved.') }}</p>
        </div>
    </footer>
</div>
