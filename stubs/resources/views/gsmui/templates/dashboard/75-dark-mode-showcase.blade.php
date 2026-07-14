<div class="min-h-screen bg-gradient-to-br from-slate-100 via-purple-100 to-slate-100 dark:from-slate-900 dark:via-purple-900 dark:to-slate-900">
    <header class="px-6 py-4 border-b border-black/10 dark:border-white/10">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-slate-900 dark:text-white">Theme Showcase</h1>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-sm text-slate-600 dark:text-white/70">Live Preview</span>
            </div>
        </div>
    </header>

    <main class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            @foreach([
                ['label' => 'Revenue', 'value' => '$124,500', 'gradient' => 'from-blue-500 to-cyan-500 dark:from-blue-600 dark:to-cyan-600'],
                ['label' => 'Users', 'value' => '12,847', 'gradient' => 'from-purple-500 to-pink-500 dark:from-purple-600 dark:to-pink-600'],
                ['label' => 'Growth', 'value' => '+23.5%', 'gradient' => 'from-green-500 to-emerald-500 dark:from-green-600 dark:to-emerald-600'],
            ] as $stat)
            <div class="bg-white/60 dark:bg-white/10 backdrop-blur-sm rounded-xl p-4 border border-white/40 dark:border-white/20">
                <p class="text-sm text-slate-600 dark:text-white/60">{{ $stat['label'] }}</p>
                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white/60 dark:bg-white/10 backdrop-blur-sm rounded-xl border border-white/40 dark:border-white/20 p-4">
                <h2 class="font-semibold text-slate-900 dark:text-white mb-4">Gradient Chart</h2>
                <div class="h-48 relative">
                    <svg class="w-full h-full" viewBox="0 0 400 150">
                        <defs>
                            <linearGradient id="glowGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" stop-color="#8b5cf6" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="#8b5cf6" stop-opacity="0"/>
                            </linearGradient>
                            <filter id="glow">
                                <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                                <feMerge><feMergeNode in="coloredBlur"/><feMergeNode in="SourceGraphic"/></feMerge>
                            </filter>
                        </defs>
                        <path fill="url(#glowGrad)" d="M0,100 Q50,80 100,60 T200,40 T300,50 T400,30 L400,150 L0,150 Z"/>
                        <path fill="none" stroke="#8b5cf6" stroke-width="3" filter="url(#glow)" d="M0,100 Q50,80 100,60 T200,40 T300,50 T400,30"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white/60 dark:bg-white/10 backdrop-blur-sm rounded-xl border border-white/40 dark:border-white/20 p-4">
                <h2 class="font-semibold text-slate-900 dark:text-white mb-4">Gradient Cards</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach([
                        ['icon' => '🚀', 'title' => 'Deploy', 'gradient' => 'from-blue-500 to-purple-500 dark:from-blue-600 dark:to-purple-600'],
                        ['icon' => '📊', 'title' => 'Analytics', 'gradient' => 'from-green-500 to-teal-500 dark:from-green-600 dark:to-teal-600'],
                        ['icon' => '🎯', 'title' => 'Goals', 'gradient' => 'from-orange-500 to-red-500 dark:from-orange-600 dark:to-red-600'],
                        ['icon' => '💎', 'title' => 'Premium', 'gradient' => 'from-purple-500 to-pink-500 dark:from-purple-600 dark:to-pink-600'],
                    ] as $card)
                    <div class="p-3 bg-gradient-to-br {{ $card['gradient'] }} rounded-lg text-center shadow-lg">
                        <span class="text-2xl">{{ $card['icon'] }}</span>
                        <p class="text-sm font-medium text-white mt-1">{{ $card['title'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</div>
