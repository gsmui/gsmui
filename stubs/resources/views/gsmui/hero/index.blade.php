@blaze(fold: true)

@props([
    'heroes' => [
        ['id' => 1, 'name' => 'macOS Menubar', 'desc' => 'Dark app-style hero with code editor preview and CTA buttons.'],
        ['id' => 2, 'name' => 'Enterprise Trust', 'desc' => 'Two-column hero with stats panel and dashboard preview.'],
        ['id' => 3, 'name' => 'Startup Launch', 'desc' => 'Orange-themed hero with feature cards and social proof.'],
        ['id' => 4, 'name' => 'Devs & Employers', 'desc' => 'Two-column hero with job matching cards and ratings.'],
        ['id' => 5, 'name' => 'Fashion Collection', 'desc' => 'E-commerce hero with product cards and promo banner.'],
        ['id' => 6, 'name' => 'Elevate Coding', 'desc' => 'Simple centered hero with gradient CTA.'],
        ['id' => 7, 'name' => 'Dark Discovery', 'desc' => 'Dark gradient hero with watch trailer CTA.'],
        ['id' => 8, 'name' => 'Design Skills', 'desc' => 'Purple-themed hero with pricing and trailer.'],
        ['id' => 9, 'name' => 'Book Promotion', 'desc' => 'Two-column hero with book mockup and pricing.'],
        ['id' => 10, 'name' => 'Blog & Articles', 'desc' => 'Hero with featured blog posts in cards.'],
        ['id' => 11, 'name' => 'NFT Marketplace', 'desc' => 'Dark purple hero with NFT artwork cards.'],
        ['id' => 12, 'name' => 'Developer Card', 'desc' => 'Credit card promo hero with card mockup.'],
        ['id' => 13, 'name' => 'Frontend Toolkit', 'desc' => 'Green hero with discovery call CTA and counter.'],
        ['id' => 14, 'name' => 'Web Presence', 'desc' => 'Hero with feature checklist and testimonial card.'],
        ['id' => 15, 'name' => 'Design Hero', 'desc' => 'Blue-themed hero with feature grid and pricing.'],
        ['id' => 16, 'name' => 'Fashion Trends', 'desc' => 'Pink hero with stats and fashion layout.'],
        ['id' => 17, 'name' => 'Communication', 'desc' => 'Cyan hero with free trial and intro video.'],
        ['id' => 18, 'name' => 'UI Kit', 'desc' => 'Centered hero with UI kit CTA and preview.'],
        ['id' => 19, 'name' => 'Fashion Accessories', 'desc' => 'Amber hero with order stats and product grid.'],
        ['id' => 20, 'name' => 'Email Campaign', 'desc' => 'Blue hero with email campaign dashboard.'],
        ['id' => 21, 'name' => 'Code Feedback', 'desc' => 'Indigo hero with developer community CTA.'],
        ['id' => 22, 'name' => 'Dev Speed', 'desc' => 'Teal hero with resource counter and access CTA.'],
        ['id' => 23, 'name' => 'v2.0 Launch', 'desc' => 'White hero with version stats and changelog.'],
        ['id' => 24, 'name' => 'Collaboration', 'desc' => 'Indigo hero with feature cards and video.'],
        ['id' => 25, 'name' => 'Community Hub', 'desc' => 'Minimal centered hero with community CTA.'],
        ['id' => 26, 'name' => 'Dev Community', 'desc' => 'Cyan hero with blog post cards.'],
        ['id' => 27, 'name' => 'Banking Dashboard', 'desc' => 'Dark banking hero with account overview.'],
        ['id' => 28, 'name' => 'UI Experience', 'desc' => 'Dark hero with platform availability grid.'],
        ['id' => 29, 'name' => 'UI Toolkit', 'desc' => 'Violet hero with design inspirations counter.'],
        ['id' => 30, 'name' => 'Community Feedback', 'desc' => 'Purple hero with developer count and CTA.'],
        ['id' => 31, 'name' => 'Beautiful Interfaces', 'desc' => 'Rose hero with demo video and free tagline.'],
        ['id' => 32, 'name' => 'SaaS Launch', 'desc' => 'Dark slate hero with free trial offer.'],
        ['id' => 33, 'name' => 'Health Dashboard', 'desc' => 'Emerald hero with health metrics panel.'],
        ['id' => 34, 'name' => 'SaaS Platform', 'desc' => 'Indigo hero with feature list and metrics.'],
        ['id' => 35, 'name' => 'Portfolio Showcase', 'desc' => 'White hero with testimonial cards and badges.'],
        ['id' => 36, 'name' => 'AI Platform', 'desc' => 'Cyan-blue hero with AI performance stats.'],
        ['id' => 37, 'name' => 'Luxury Collection', 'desc' => 'Dark luxury hero with craftsmanship features.'],
        ['id' => 38, 'name' => 'Launch Countdown', 'desc' => 'Violet hero with countdown timer display.'],
        ['id' => 39, 'name' => 'Universal App', 'desc' => 'White hero with device compatibility grid.'],
        ['id' => 40, 'name' => 'Open Source', 'desc' => 'Dark hero with contributor badges and stats.'],
        ['id' => 41, 'name' => 'Glassmorphism', 'desc' => 'Dark glassmorphism hero with frosted cards.'],
        ['id' => 42, 'name' => 'SaaS Metrics', 'desc' => 'White hero with KPI metric cards.'],
        ['id' => 43, 'name' => 'Testimonials', 'desc' => 'Emerald hero with customer testimonial cards.'],
        ['id' => 44, 'name' => 'Workspace', 'desc' => 'White hero with step-by-step onboarding.'],
        ['id' => 45, 'name' => 'Agency', 'desc' => 'Gray hero with client stats and portfolio.'],
        ['id' => 46, 'name' => 'Learning Platform', 'desc' => 'Orange hero with course cards and ratings.'],
        ['id' => 47, 'name' => 'Travel', 'desc' => 'Sky blue hero with destination cards.'],
        ['id' => 48, 'name' => 'Cybersecurity', 'desc' => 'Emerald hero with security dashboard panel.'],
        ['id' => 49, 'name' => 'Conference', 'desc' => 'Rose hero with event speaker stats.'],
        ['id' => 50, 'name' => 'Product Showcase', 'desc' => 'Dark final hero celebrating the collection.'],
    ],
])

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro Heroes</h1>
                <p class="text-sm text-zinc-500">{{ count($heroes) }} production-ready hero sections</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">{{ count($heroes) }} Components</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">Dark Mode</span>
                <span class="rounded-full bg-violet-100 dark:bg-violet-900/30 px-3 py-1 text-xs font-medium text-violet-700 dark:text-violet-300">Responsive</span>
            </div>
        </div>
        {{-- Nav --}}
        <div class="border-t border-zinc-200 dark:border-white/10 overflow-x-auto">
            <div class="mx-auto flex max-w-7xl gap-1 px-6 py-2 text-xs font-medium text-zinc-500">
                @for ($i = 1; $i <= count($heroes); $i++)
                    <a href="#hero-{{ $i }}" class="shrink-0 rounded-md px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 hover:text-zinc-900 dark:hover:text-white transition-all">H{{ $i }}</a>
                @endfor
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 space-y-24">
        @foreach ($heroes as $hero)
            <section id="hero-{{ $hero['id'] }}" class="scroll-mt-32">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-zinc-200 dark:bg-zinc-700 px-3 py-1 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                            Hero {{ $hero['id'] }}
                        </span>
                        <h2 class="mt-2 text-xl font-bold text-zinc-900 dark:text-white">{{ $hero['name'] }}</h2>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $hero['desc'] }}</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-zinc-400">
                        <span class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1">gsmui:hero.hero-{{ $hero['id'] }}</span>
                        <button onclick="navigator.clipboard.writeText('&lt;x-gsmui::hero.hero-{{ $hero['id'] }} /&gt;')" class="rounded-md border border-zinc-200 dark:border-white/10 px-2 py-1 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all" title="Copy usage code">Copy</button>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 shadow-sm">
                    <x-dynamic-component :component="'gsmui::hero.hero-' . $hero['id']" />
                </div>
            </section>
        @endforeach

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ count($heroes) }} Hero Components</p>
            <p class="mt-2 text-sm text-zinc-500">Fully responsive · Dark mode ready · Tailwind CSS</p>
            <p class="mt-1 text-xs text-zinc-400">Copy any hero with <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::hero.hero-{n} /&gt;</code></p>
        </footer>
    </main>
</div>
