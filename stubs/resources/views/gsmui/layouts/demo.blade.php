@blaze(fold: true)

<div
    x-data="{
        activeType: 'sidebar',
        sidebarOpen: false,
        drawerOpen: false,
        overlayOpen: false,
        pushOpen: false,
        slideOpen: false,
        types: [
            { id: 'sidebar', name: 'Sidebar', desc: 'Static side panel, always visible', icon: 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5' },
            { id: 'drawer', name: 'Drawer', desc: 'Overlays with backdrop, closes on click-away', icon: 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5' },
            { id: 'overlay', name: 'Overlay', desc: 'Floating overlay with backdrop from the side', icon: 'M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25' },
            { id: 'push', name: 'Push', desc: 'Pushes main content aside when opened', icon: 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9' },
            { id: 'slide', name: 'Slide', desc: 'Slides over content without backdrop', icon: 'M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9' },
            { id: 'floating', name: 'Floating', desc: 'Floating card detached from edges', icon: 'M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15' },
            { id: 'rail', name: 'Rail', desc: 'Compact icon-only rail', icon: 'M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5' },
        ],
        toggleType(type) {
            if (type === 'sidebar' || type === 'floating') {
                this.sidebarOpen = !this.sidebarOpen;
            } else if (type === 'drawer') {
                window.dispatchEvent(new CustomEvent('toggle-sidebar-demo-drawer'));
            } else if (type === 'overlay') {
                window.dispatchEvent(new CustomEvent('toggle-sidebar-demo-overlay'));
            } else if (type === 'push') {
                window.dispatchEvent(new CustomEvent('toggle-sidebar-demo-push'));
            } else if (type === 'slide') {
                window.dispatchEvent(new CustomEvent('toggle-sidebar-demo-slide'));
            }
        },
        init() {
            // Show sidebar by default
            this.$nextTick(() => this.sidebarOpen = true);
        }
    }"
    class="min-h-screen bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-white"
    data-gsmui-layout-demo
>
    {{-- ============================================================ --}}
    {{-- LAYOUT HEADER --}}
    {{-- ============================================================ --}}
    <gsmui:layouts.header
        brand="Gsmui UI"
        logo="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%233b82f6'/%3E%3Ctext x='16' y='22' text-anchor='middle' font-family='system-ui' font-weight='bold' font-size='18' fill='white'%3EG%3C/text%3E%3C/svg%3E"
        variant="glass"
        searchable
        searchPlaceholder="Search components..."
        id="demo-header"
    >
        <x-slot:nav>
            <a href="#" class="px-3 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-150" @click.prevent="">Docs</a>
            <a href="#" class="px-3 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-150" @click.prevent="">Components</a>
            <a href="#" class="px-3 py-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 rounded-md hover:bg-blue-50 dark:hover:bg-blue-950/50 transition-colors duration-150" @click.prevent="">Layouts</a>
            <a href="#" class="px-3 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-150" @click.prevent="">Themes</a>
        </x-slot:nav>

        <x-slot:actions>
            <a href="https://github.com" target="_blank" class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
                <span class="hidden sm:inline">Star on GitHub</span>
            </a>
            <gsmui:button variant="primary" size="sm">
                Get Started
            </gsmui:button>
        </x-slot:actions>
    </gsmui:layouts.header>

    {{-- ============================================================ --}}
    {{-- HERO SECTION --}}
    {{-- ============================================================ --}}
    <section class="relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800">
        {{-- Background decoration --}}
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/5 dark:bg-blue-500/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-72 h-72 bg-violet-500/5 dark:bg-violet-500/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-12 sm:py-16 text-center">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 mb-4 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3">
                    <path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 00-1.09-1.03l-2.955 3.129V2.75z" />
                    <path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" />
                </svg>
                v2.0 — 7 sidebar types
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-zinc-900 dark:text-white">
                Layout Sidebar
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-violet-600 dark:from-blue-400 dark:to-violet-400">Demo</span>
            </h1>

            <p class="mt-4 text-base sm:text-lg text-zinc-500 dark:text-zinc-400 max-w-2xl mx-auto leading-relaxed">
                Explore all 7 sidebar variants — from static sidebars and overlay drawers to push layouts and compact rails.
                Each type is fully interactive with navigation groups, icons, badges, sub-menus, and user profiles.
            </p>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- TYPE SELECTOR — Grid of cards --}}
    {{-- ============================================================ --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-3 sm:gap-4">
            <template x-for="t in types" :key="t.id">
                <button
                    type="button"
                    @click="activeType = t.id; toggleType(t.id)"
                    :class="{
                        'ring-2 ring-blue-500 dark:ring-blue-400 bg-blue-50 dark:bg-blue-950/30 border-blue-200 dark:border-blue-800': activeType === t.id,
                        'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:border-zinc-300 dark:hover:border-zinc-700': activeType !== t.id,
                    }"
                    class="flex flex-col items-center gap-2 p-3 sm:p-4 rounded-xl border transition-all duration-200 group text-center"
                >
                    <div class="size-8 sm:size-10 rounded-lg flex items-center justify-center"
                        :class="activeType === t.id ? 'bg-blue-500 text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 group-hover:bg-zinc-200 dark:group-hover:bg-zinc-700'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 sm:size-5">
                            <path :d="t.icon" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-xs sm:text-sm font-semibold" x-text="t.name"></div>
                        <div class="hidden sm:block text-[10px] sm:text-xs text-zinc-400 dark:text-zinc-500 mt-0.5 leading-tight" x-text="t.desc"></div>
                    </div>
                    <div class="text-[10px] font-mono px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500"
                        :class="activeType === t.id ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' : ''"
                        x-text="'gsmui:layouts.sidebar type=&quot;' + t.id + '&quot;'"
                    ></div>
                </button>
            </template>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- DEMO AREA — Shows the selected sidebar type --}}
    {{-- ============================================================ --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 pb-12 sm:pb-16">
        {{-- Instructions bar --}}
        <div class="flex items-center justify-between mb-4 px-4 py-3 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center gap-2 text-sm">
                <span class="font-semibold text-zinc-900 dark:text-white" x-text="'Active: ' + types.find(t => t.id === activeType)?.name"></span>
                <span class="text-zinc-400 dark:text-zinc-500">·</span>
                <span class="text-zinc-500 dark:text-zinc-400" x-text="'Click the <strong>' + types.find(t => t.id === activeType)?.name + '</strong> card above to toggle'"></span>
            </div>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-zinc-400 dark:text-zinc-500">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                </svg>
                <span class="text-xs text-zinc-400 dark:text-zinc-500">Toggle via card click or <kbd class="px-1 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 font-mono text-zinc-500 dark:text-zinc-400">Escape</kbd></span>
            </div>
        </div>

        {{-- Demo container --}}
        <div class="relative min-h-[500px] rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden shadow-xl shadow-zinc-200/20 dark:shadow-black/20">
            {{-- ================================================================ --}}
            {{-- 1. SIDEBAR (static, always visible) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'sidebar'" x-cloak class="flex h-[500px]">
                <gsmui:layouts.sidebar type="sidebar" width="sm" variant="elevated" behavior="static">
                    <gsmui:layouts.sidebar.header brand="Gsmui UI" closeable>
                        <x-slot:actions>
                            <gsmui:button variant="subtle" size="xs" square aria-label="Notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.117 1 8.22 8.22 0 013.135 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                    <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 29.583 29.583 0 004.831-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.119-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18.75a2.25 2.25 0 004.5 0 24.6 24.6 0 01-4.5 0z" clip-rule="evenodd" />
                                </svg>
                            </gsmui:button>
                        </x-slot:actions>
                    </gsmui:layouts.sidebar.header>

                    <div class="flex-1 px-3 py-2 space-y-4 overflow-y-auto">
                        <gsmui:layouts.sidebar.group label="Main" icon="home-modern">
                            <gsmui:layouts.sidebar.item label="Dashboard" icon="chart-pie" active />
                            <gsmui:layouts.sidebar.item label="Analytics" icon="arrow-trending-up" badge="+12%" badgeColor="emerald" />
                            <gsmui:layouts.sidebar.item label="Reports" icon="document-text" />
                        </gsmui:layouts.sidebar.group>

                        <gsmui:layouts.sidebar.group label="Management" icon="cog" collapsible defaultOpen>
                            <gsmui:layouts.sidebar.item label="Users" icon="users" badge="24" />
                            <gsmui:layouts.sidebar.item label="Roles" icon="shield-check" />
                            <gsmui:layouts.sidebar.item label="Settings" icon="cog" hasSubItems>
                                <gsmui:layouts.sidebar.item label="General" href="#" />
                                <gsmui:layouts.sidebar.item label="Security" href="#" />
                                <gsmui:layouts.sidebar.item label="Notifications" href="#" />
                            </gsmui:layouts.sidebar.item>
                        </gsmui:layouts.sidebar.group>

                        <gsmui:layouts.sidebar.group label="Projects" icon="folder" collapsible defaultOpen>
                            <gsmui:layouts.sidebar.item label="Gsmui UI" icon="cube" badge="Pro" badgeColor="blue" variant="filled" color="primary" />
                            <gsmui:layouts.sidebar.item label="Flux Pro" icon="cube" />
                            <gsmui:layouts.sidebar.item label="Marketing" icon="megaphone" />
                        </gsmui:layouts.sidebar.group>
                    </div>

                    <gsmui:layouts.sidebar.footer
                        user="John Doe"
                        email="john@example.com"
                        avatar="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' rx='50' fill='%233b82f6'/%3E%3Ccircle cx='50' cy='38' r='18' fill='%2393c5fd'/%3E%3Cellipse cx='50' cy='70' rx='30' ry='22' fill='%2393c5fd'/%3E%3C/svg%3E"
                    />
                </gsmui:layouts.sidebar>

                {{-- Content area --}}
                <div class="flex-1 p-6 overflow-y-auto">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="size-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 text-blue-600 dark:text-blue-400">
                                <path d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.117 1 8.22 8.22 0 013.135 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                                <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 29.583 29.583 0 004.831-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.119-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18.75a2.25 2.25 0 004.5 0 24.6 24.6 0 01-4.5 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Dashboard Overview</h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Static sidebar — always visible, no toggle needed</p>
                        </div>
                    </div>

                    {{-- Stats grid --}}
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20 border border-blue-200 dark:border-blue-800">
                            <p class="text-xs font-medium text-blue-600 dark:text-blue-400 uppercase tracking-wider">Revenue</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-200 mt-1">$48,250</p>
                            <p class="text-xs text-blue-500 dark:text-blue-400 mt-1">↑ 12.5% this month</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-950/30 dark:to-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                            <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Users</p>
                            <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-200 mt-1">2,847</p>
                            <p class="text-xs text-emerald-500 dark:text-emerald-400 mt-1">↑ 8.3% this week</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-950/30 dark:to-violet-900/20 border border-violet-200 dark:border-violet-800">
                            <p class="text-xs font-medium text-violet-600 dark:text-violet-400 uppercase tracking-wider">Active</p>
                            <p class="text-2xl font-bold text-violet-900 dark:text-violet-200 mt-1">1,203</p>
                            <p class="text-xs text-violet-500 dark:text-violet-400 mt-1">currently online</p>
                        </div>
                    </div>

                    {{-- Activity list --}}
                    <div class="space-y-2">
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="size-2 rounded-full bg-emerald-500"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-zinc-900 dark:text-white">New user registered</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">2 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="size-2 rounded-full bg-blue-500"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-zinc-900 dark:text-white">Payment received — $2,400</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">15 minutes ago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="size-2 rounded-full bg-amber-500"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-zinc-900 dark:text-white">Server deployment completed</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">1 hour ago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <div class="size-2 rounded-full bg-violet-500"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-zinc-900 dark:text-white">Gsmui UI v2.0 released</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500">3 hours ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- 2. DRAWER (overlay with backdrop) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'drawer'" x-cloak class="flex h-[500px] relative">
                <gsmui:layouts.sidebar type="drawer" width="sm" variant="bordered" id="demo-drawer">
                    <gsmui:layouts.sidebar.header brand="Gsmui UI" closeable />
                    <div class="flex-1 px-3 py-2 space-y-4 overflow-y-auto">
                        <gsmui:layouts.sidebar.group label="Main" icon="home-modern">
                            <gsmui:layouts.sidebar.item label="Dashboard" icon="chart-pie" />
                            <gsmui:layouts.sidebar.item label="Analytics" icon="arrow-trending-up" badge="+12%" badgeColor="emerald" />
                            <gsmui:layouts.sidebar.item label="Reports" icon="document-text" />
                        </gsmui:layouts.sidebar.group>
                    </div>
                    <gsmui:layouts.sidebar.footer user="John Doe" email="john@example.com" />
                </gsmui:layouts.sidebar>

                {{-- Full-width content --}}
                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-blue-500 to-violet-600 flex items-center justify-center mb-4 shadow-lg shadow-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
                            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Drawer Sidebar</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-md">Slides in from the left with a backdrop overlay. Click the backdrop or use the close button to dismiss.</p>
                    <button type="button" class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors" @click="$dispatch(new CustomEvent('toggle-sidebar-demo-drawer'))">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10zm0 5.25a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                        </svg>
                        Toggle Drawer
                    </button>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- 3. OVERLAY (floating overlay) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'overlay'" x-cloak class="flex h-[500px] relative">
                <gsmui:layouts.sidebar type="overlay" width="sm" variant="glass" id="demo-overlay">
                    <gsmui:layouts.sidebar.header brand="Notifications" closeable />
                    <div class="flex-1 px-3 py-2 space-y-3 overflow-y-auto">
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">New comment on your post</p>
                            <p class="text-xs text-zinc-400 mt-1">5 minutes ago</p>
                        </div>
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Server update available</p>
                            <p class="text-xs text-zinc-400 mt-1">12 minutes ago</p>
                        </div>
                        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800/50">
                            <p class="text-sm font-medium text-zinc-900 dark:text-white">Welcome to Gsmui UI!</p>
                            <p class="text-xs text-zinc-400 mt-1">1 hour ago</p>
                        </div>
                    </div>
                </gsmui:layouts.sidebar>

                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center mb-4 shadow-lg shadow-amber-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
                            <path d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Overlay Sidebar</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-md">Floating overlay from the side with a semi-transparent backdrop. Perfect for notifications or secondary panels.</p>
                    <button type="button" class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-amber-500 text-white hover:bg-amber-600 transition-colors" @click="$dispatch(new CustomEvent('toggle-sidebar-demo-overlay'))">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Toggle Overlay
                    </button>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- 4. PUSH (pushes content) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'push'" x-cloak class="h-[500px]">
                <gsmui:layouts.sidebar type="push" width="sm" variant="gradient" id="demo-push">
                    <x-slot:content>
                        <div class="p-6 space-y-6 overflow-y-auto h-full">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white">Project Dashboard</h2>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">Watch the content shift when you toggle the sidebar</p>
                                </div>
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors" @click="$dispatch(new CustomEvent('toggle-sidebar-demo-push'))">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                                        <path fill-rule="evenodd" d="M3.25 3A2.25 2.25 0 001 5.25v9.5A2.25 2.25 0 003.25 17h13.5A2.25 2.25 0 0019 14.75v-9.5A2.25 2.25 0 0015.75 3H3.25zM3 5.25A.25.25 0 013.25 5h13.5a.25.25 0 01.25.25v9.5a.25.25 0 01-.25.25H3.25a.25.25 0 01-.25-.25v-9.5z" clip-rule="evenodd" />
                                    </svg>
                                    Toggle Sidebar
                                </button>
                            </div>

                            {{-- Stats cards --}}
                            <div class="grid grid-cols-3 gap-4">
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Files</p>
                                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">128</p>
                                    <div class="mt-2 h-1.5 rounded-full bg-zinc-100 dark:bg-zinc-700 overflow-hidden">
                                        <div class="h-full w-3/4 rounded-full bg-blue-500"></div>
                                    </div>
                                </div>
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Storage Used</p>
                                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">2.4 GB</p>
                                    <div class="mt-2 h-1.5 rounded-full bg-zinc-100 dark:bg-zinc-700 overflow-hidden">
                                        <div class="h-full w-2/5 rounded-full bg-emerald-500"></div>
                                    </div>
                                </div>
                                <div class="p-4 rounded-xl bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 shadow-sm">
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Team Members</p>
                                    <p class="text-2xl font-bold text-zinc-900 dark:text-white mt-1">8</p>
                                    <div class="mt-2 flex -space-x-2">
                                        <div class="size-6 rounded-full bg-blue-500 border-2 border-white dark:border-zinc-800"></div>
                                        <div class="size-6 rounded-full bg-violet-500 border-2 border-white dark:border-zinc-800"></div>
                                        <div class="size-6 rounded-full bg-emerald-500 border-2 border-white dark:border-zinc-800"></div>
                                        <div class="size-6 rounded-full bg-amber-500 border-2 border-white dark:border-zinc-800"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- File list --}}
                            <div class="space-y-2">
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                                    <div class="size-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-blue-600 dark:text-blue-400">
                                            <path d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">project-proposal.pdf</p>
                                        <p class="text-xs text-zinc-400">2.3 MB · Updated 2 hours ago</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                                    <div class="size-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-emerald-600 dark:text-emerald-400">
                                            <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">architecture-diagram.png</p>
                                        <p class="text-xs text-zinc-400">4.1 MB · Updated yesterday</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                                    <div class="size-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4 text-amber-600 dark:text-amber-400">
                                            <path d="M3.75 3A1.75 1.75 0 002 4.75v3.5A1.75 1.75 0 003.75 10H5v5a3 3 0 003 3h4a3 3 0 003-3v-5h1.25A1.75 1.75 0 0018 8.25v-3.5A1.75 1.75 0 0016.25 3H3.75z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-zinc-900 dark:text-white">release-notes-v2.0.doc</p>
                                        <p class="text-xs text-zinc-400">856 KB · Updated 3 days ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot:content>

                    {{-- Sidebar content --}}
                    <gsmui:layouts.sidebar.header brand="Files" />
                    <div class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">
                        <gsmui:layouts.sidebar.group label="Documents" icon="folder-open" collapsible defaultOpen>
                            <gsmui:layouts.sidebar.item label="Project Plan" icon="document-text" />
                            <gsmui:layouts.sidebar.item label="Requirements" icon="document-text" />
                            <gsmui:layouts.sidebar.item label="Architecture" icon="document-text" badge="v2" badgeColor="violet" />
                        </gsmui:layouts.sidebar.group>
                        <gsmui:layouts.sidebar.group label="Media" icon="photo" collapsible>
                            <gsmui:layouts.sidebar.item label="Screenshots" icon="camera" />
                            <gsmui:layouts.sidebar.item label="Videos" icon="video-camera" />
                            <gsmui:layouts.sidebar.item label="Mockups" icon="swatch" />
                        </gsmui:layouts.sidebar.group>
                    </div>
                </gsmui:layouts.sidebar>
            </div>

            {{-- ================================================================ --}}
            {{-- 5. SLIDE (slides over) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'slide'" x-cloak class="flex h-[500px] relative">
                <gsmui:layouts.sidebar type="slide" width="sm" variant="neo" id="demo-slide">
                    <gsmui:layouts.sidebar.header brand="Playlist" closeable>
                        <x-slot:actions>
                            <gsmui:button variant="subtle" size="xs" square>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path d="M19.5 6.75h-15a.75.75 0 010-1.5h15a.75.75 0 010 1.5z" />
                                    <path d="M19.5 11.25h-15a.75.75 0 010-1.5h15a.75.75 0 010 1.5z" />
                                    <path d="M19.5 15.75h-15a.75.75 0 010-1.5h15a.75.75 0 010 1.5z" />
                                </svg>
                            </gsmui:button>
                        </x-slot:actions>
                    </gsmui:layouts.sidebar.header>
                    <div class="flex-1 px-3 py-2 space-y-2 overflow-y-auto">
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <div class="size-10 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold">01</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">Midnight Serenade</p>
                                <p class="text-xs text-zinc-400">3:45</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <div class="size-10 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-xs font-bold">02</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">Ocean Waves</p>
                                <p class="text-xs text-zinc-400">4:12</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <div class="size-10 rounded-lg bg-gradient-to-br from-violet-400 to-violet-600 flex items-center justify-center text-white text-xs font-bold">03</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">Starlight</p>
                                <p class="text-xs text-zinc-400">5:30</p>
                            </div>
                        </div>
                    </div>
                </gsmui:layouts.sidebar>

                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center mb-4 shadow-lg shadow-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
                            <path d="M10.8 3.65a.75.75 0 00-1.6 0L9 6.01H6.75a.75.75 0 000 1.5H9l-.2 2.36a.75.75 0 001.6.15l.2-2.36h1.5l-.2 2.36a.75.75 0 001.6.15l.2-2.36h2.25a.75.75 0 000-1.5H13.8l.2-2.36a.75.75 0 00-1.6-.15L12.2 6.01h-1.5l.2-2.36z" />
                            <path d="M12 15.75a.75.75 0 01.75.75v.75h.75a.75.75 0 010 1.5h-.75V19.5a.75.75 0 01-1.5 0v-.75h-.75a.75.75 0 010-1.5h.75v-.75a.75.75 0 01.75-.75z" />
                            <path fill-rule="evenodd" d="M4.5 3.75C4.5 2.784 5.284 2 6.25 2h11.5c.966 0 1.75.784 1.75 1.75v16.5c0 .966-.784 1.75-1.75 1.75H6.25a1.75 1.75 0 01-1.75-1.75V3.75zm1.75.25a.25.25 0 00-.25.25v16.5c0 .138.112.25.25.25h11.5a.25.25 0 00.25-.25V4.25a.25.25 0 00-.25-.25H6.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Slide Sidebar</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-md">Slides over content without a backdrop. Subtle shadow separates it from the main content.</p>
                    <button type="button" class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-emerald-500 text-white hover:bg-emerald-600 transition-colors" @click="$dispatch(new CustomEvent('toggle-sidebar-demo-slide'))">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                        </svg>
                        Toggle Slide
                    </button>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- 6. FLOATING (detached card) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'floating'" x-cloak class="flex h-[500px] relative">
                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center mb-4 shadow-lg shadow-violet-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
                            <path fill-rule="evenodd" d="M3 6a3 3 0 013-3h12a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6zm14.25 6a.75.75 0 01-.22.53l-2.25 2.25a.75.75 0 11-1.06-1.06L15.44 12l-1.72-1.72a.75.75 0 111.06-1.06l2.25 2.25c.141.14.22.331.22.53zm-10.28-.53a.75.75 0 000 1.06l2.25 2.25a.75.75 0 101.06-1.06L8.56 12l1.72-1.72a.75.75 0 10-1.06-1.06l-2.25 2.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Floating Sidebar</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-md">Detached card-style sidebar with rounded corners. Floats independently from the viewport edges.</p>
                    <div class="mt-4 flex items-center gap-2">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" x-model="sidebarOpen" class="sr-only peer">
                            <div class="w-9 h-5 bg-zinc-200 dark:bg-zinc-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-zinc-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">
                            <span x-show="sidebarOpen" x-cloak>Showing</span>
                            <span x-show="!sidebarOpen" x-cloak>Hidden</span>
                        </span>
                    </div>
                </div>

                {{-- Floating sidebar --}}
                <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-4" class="absolute inset-y-3 right-3 z-10">
                    <gsmui:layouts.sidebar type="floating" width="sm" variant="floating" color="blue">
                        <gsmui:layouts.sidebar.header brand="Quick Actions" closeable>
                            <x-slot:actions>
                                <gsmui:button variant="subtle" size="xs" square @click="sidebarOpen = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </gsmui:button>
                            </x-slot:actions>
                        </gsmui:layouts.sidebar.header>
                        <div class="flex-1 px-3 py-2 space-y-1 overflow-y-auto">
                            <gsmui:layouts.sidebar.item label="New Document" icon="document-plus" />
                            <gsmui:layouts.sidebar.item label="Upload File" icon="cloud-arrow-up" />
                            <gsmui:layouts.sidebar.item label="Invite Team" icon="user-plus" />
                            <gsmui:layouts.sidebar.item label="Export Data" icon="arrow-down-tray" />
                            <hr class="my-2 border-zinc-200 dark:border-zinc-700" />
                            <gsmui:layouts.sidebar.item label="Keyboard Shortcuts" icon="command-line" />
                        </div>
                    </gsmui:layouts.sidebar>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- 7. RAIL (icon-only compact) --}}
            {{-- ================================================================ --}}
            <div x-show="activeType === 'rail'" x-cloak class="flex h-[500px]">
                <gsmui:layouts.sidebar type="sidebar" variant="dark" behavior="static">
                    <div class="flex flex-col items-center gap-3 py-3" data-gsmui-sidebar-rail>
                        {{-- Mini logo --}}
                        <div class="size-8 rounded-lg bg-blue-600 flex items-center justify-center text-white text-sm font-bold mb-1">G</div>

                        {{-- Rail items --}}
                        <button class="size-9 rounded-lg flex items-center justify-center bg-blue-600 text-white" title="Dashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"><path d="M1 1.75A.75.75 0 011.75 1h1.628a1.75 1.75 0 011.734 1.51L5.18 3a65.25 65.25 0 0113.36 1.412.75.75 0 01.58.875 48.645 48.645 0 01-1.618 6.2.75.75 0 01-.712.513H6a2.503 2.503 0 01-2.292-.781L1.397 2.51zm5.138 10.563A2.502 2.502 0 019.5 12.365v.002a2.5 2.5 0 01-2.983 2.5 2.5 2.5 0 01-.379-2.615zM11 15a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5A.75.75 0 0111 15z"/></svg>
                        </button>
                        <button class="size-9 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors" title="Analytics">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"><path d="M15.5 2A1.5 1.5 0 0014 3.5v13a1.5 1.5 0 001.5 1.5h1a1.5 1.5 0 001.5-1.5v-13A1.5 1.5 0 0016.5 2h-1zM9.5 6A1.5 1.5 0 008 7.5v9A1.5 1.5 0 009.5 18h1a1.5 1.5 0 001.5-1.5v-9A1.5 1.5 0 0010.5 6h-1zM3.5 10A1.5 1.5 0 002 11.5v5A1.5 1.5 0 003.5 18h1A1.5 1.5 0 006 16.5v-5A1.5 1.5 0 004.5 10h-1z"/></svg>
                        </button>
                        <button class="size-9 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors" title="Messages">
                            <span class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"><path d="M1 11.5A3.5 3.5 0 004.5 15H7l2.5 3V15h6A3.5 3.5 0 0019 11.5v-5A3.5 3.5 0 0015.5 3h-11A3.5 3.5 0 001 6.5v5z"/></svg>
                                <span class="absolute -top-1 -right-1 size-2.5 rounded-full bg-red-500 border-2 border-zinc-900"></span>
                            </span>
                        </button>
                        <button class="size-9 rounded-lg flex items-center justify-center text-zinc-400 hover:text-white hover:bg-zinc-800 transition-colors" title="Settings">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5"><path fill-rule="evenodd" d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.205 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.82 7.593a1 1 0 01-.205-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                </gsmui:layouts.sidebar>

                <div class="flex-1 flex flex-col items-center justify-center p-6 text-center">
                    <div class="size-16 rounded-2xl bg-gradient-to-br from-zinc-600 to-zinc-800 flex items-center justify-center mb-4 shadow-lg shadow-zinc-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8 text-white">
                            <path fill-rule="evenodd" d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm8.25-5.25a.75.75 0 01.75.75v8.25a.75.75 0 01-1.5 0V7.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Rail Sidebar</h3>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400 max-w-md">Compact icon-only rail navigation. Saves vertical space while providing quick access to main sections with tooltip labels.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CODE SNIPPET SECTION --}}
    {{-- ============================================================ --}}
    <section class="max-w-4xl mx-auto px-4 sm:px-6 pb-12 sm:pb-16">
        <div class="p-4 sm:p-6 rounded-2xl bg-zinc-900 dark:bg-zinc-800 border border-zinc-800 dark:border-zinc-700">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="flex gap-1.5">
                        <div class="size-2.5 rounded-full bg-red-500"></div>
                        <div class="size-2.5 rounded-full bg-yellow-500"></div>
                        <div class="size-2.5 rounded-full bg-emerald-500"></div>
                    </div>
                    <span class="text-xs font-mono text-zinc-500 ml-2">gsmui:layouts.sidebar — type="<span x-text="activeType"></span>"</span>
                </div>
            </div>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'sidebar'"><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Static sidebar --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"sidebar"</span> <span class="text-amber-400">width</span>=<span class="text-emerald-400">"sm"</span> <span class="text-amber-400">variant</span>=<span class="text-emerald-400">"elevated"</span><span class="text-purple-400">&gt;</span>
    <span class="text-purple-400">&lt;gsmui:layouts.sidebar.header</span> <span class="text-amber-400">brand</span>=<span class="text-emerald-400">"MyApp"</span> <span class="text-amber-400">closeable</span> <span class="text-purple-400">/&gt;</span>
    <span class="text-purple-400">&lt;gsmui:layouts.sidebar.group</span> <span class="text-amber-400">label</span>=<span class="text-emerald-400">"Main"</span><span class="text-purple-400">&gt;</span>
        <span class="text-purple-400">&lt;gsmui:layouts.sidebar.item</span> <span class="text-amber-400">label</span>=<span class="text-emerald-400">"Dashboard"</span> <span class="text-amber-400">icon</span>=<span class="text-emerald-400">"chart-pie"</span> <span class="text-amber-400">active</span> <span class="text-purple-400">/&gt;</span>
    <span class="text-purple-400">&lt;/gsmui:layouts.sidebar.group&gt;</span>
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'drawer'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Drawer with backdrop --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"drawer"</span> <span class="text-amber-400">id</span>=<span class="text-emerald-400">"my-drawer"</span><span class="text-purple-400">&gt;</span>
    ...
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span>

<span class="text-zinc-500">&lt;!-- Toggle button anywhere on page --&gt;</span>
<span class="text-purple-400">&lt;button</span> <span class="text-amber-400">onclick</span>=<span class="text-emerald-400">"window.dispatchEvent(
    new CustomEvent('toggle-sidebar-my-drawer')
)"</span><span class="text-purple-400">&gt;</span>Toggle<span class="text-purple-400">&lt;/button&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'push'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Push sidebar (pushes content) --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"push"</span> <span class="text-amber-400">width</span>=<span class="text-emerald-400">"sm"</span> <span class="text-amber-400">id</span>=<span class="text-emerald-400">"my-push"</span><span class="text-purple-400">&gt;</span>
    <span class="text-purple-400">&lt;x-slot:content&gt;</span>
        <span class="text-zinc-500">&lt;!-- Main content pushed aside --&gt;</span>
    <span class="text-purple-400">&lt;/x-slot:content&gt;</span>
    <span class="text-zinc-500">&lt;!-- Sidebar items --&gt;</span>
    <span class="text-purple-400">&lt;gsmui:layouts.sidebar.item</span> <span class="text-amber-400">label</span>=<span class="text-emerald-400">"Files"</span> <span class="text-purple-400">/&gt;</span>
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'rail'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Compact rail --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"rail"</span> <span class="text-amber-400">variant</span>=<span class="text-emerald-400">"dark"</span><span class="text-purple-400">&gt;</span>
    <span class="text-purple-400">&lt;gsmui:layouts.sidebar.item</span> <span class="text-amber-400">label</span>=<span class="text-emerald-400">"Home"</span> <span class="text-amber-400">icon</span>=<span class="text-emerald-400">"home"</span> <span class="text-purple-400">/&gt;</span>
    ...
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'floating'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Floating card sidebar --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"floating"</span> <span class="text-amber-400">variant</span>=<span class="text-emerald-400">"floating"</span><span class="text-purple-400">&gt;</span>
    ...
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'overlay'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Overlay sidebar --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"overlay"</span> <span class="text-amber-400">variant</span>=<span class="text-emerald-400">"glass"</span><span class="text-purple-400">&gt;</span>
    ...
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
            <pre class="text-sm leading-relaxed overflow-x-auto" x-show="activeType === 'slide'" x-cloak><code class="text-zinc-300"><span class="text-zinc-500">&lt;!-- Slide sidebar (no backdrop) --&gt;</span>
<span class="text-purple-400">&lt;gsmui:layouts.sidebar</span> <span class="text-amber-400">type</span>=<span class="text-emerald-400">"slide"</span> <span class="text-amber-400">variant</span>=<span class="text-emerald-400">"neo"</span><span class="text-purple-400">&gt;</span>
    ...
<span class="text-purple-400">&lt;/gsmui:layouts.sidebar&gt;</span></code></pre>
        </div>

        <div class="mt-3 flex items-center gap-2 text-xs text-zinc-400 dark:text-zinc-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-3.5">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
            </svg>
            <span>Code snippet updates based on the currently active sidebar type. Click a type card above to see its code.</span>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- LAYOUT FOOTER --}}
    {{-- ============================================================ --}}
    <gsmui:layouts.footer
        brand="Gsmui UI"
        description="A comprehensive layout component library for Laravel. Design beautiful interfaces with 7 sidebar types, headers, and footers."
        variant="divided"
        copyright="Gsmui UI. All rights reserved."
    >
        <x-slot:one>
            <gsmui:layouts.footer.column title="Sidebars">
                <x-slot:links>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Static Sidebar</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Drawer</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Overlay</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Push &amp; Slide</a>
                </x-slot:links>
            </gsmui:layouts.footer.column>
        </x-slot:one>

        <x-slot:two>
            <gsmui:layouts.footer.column title="Components">
                <x-slot:links>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Navigation Items</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Groups</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Headers &amp; Footers</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Badges &amp; Icons</a>
                </x-slot:links>
            </gsmui:layouts.footer.column>
        </x-slot:two>

        <x-slot:three>
            <gsmui:layouts.footer.column title="Resources">
                <x-slot:links>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Documentation</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">GitHub</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Changelog</a>
                    <a href="#" class="block py-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">Support</a>
                </x-slot:links>
            </gsmui:layouts.footer.column>
        </x-slot:three>

        <x-slot:social>
            <a href="#" class="size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors" aria-label="Twitter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
            </a>
            <a href="#" class="size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors" aria-label="GitHub">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg>
            </a>
            <a href="#" class="size-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-white hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors" aria-label="Dribbble">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.245.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z" /></svg>
            </a>
        </x-slot:social>

        <x-slot:bottom>
            <div class="flex items-center gap-4 text-xs">
                <a href="#" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">Privacy Policy</a>
                <a href="#" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">Terms of Service</a>
                <a href="#" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">Cookie Policy</a>
            </div>
        </x-slot:bottom>
    </gsmui:layouts.footer>
</div>
