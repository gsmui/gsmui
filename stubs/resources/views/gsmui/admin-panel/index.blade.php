@props([
    'stats' => [],
    'recentActivities' => [],
    'users' => [],
    'sections' => [],
    'class' => '',
])

<?php
$id = 'admin-panel-' . uniqid();
$stats = $stats ?: [
    ['label' => 'Users', 'value' => '2,847', 'change' => '+12%', 'trend' => 'up', 'icon' => 'users'],
    ['label' => 'Revenue', 'value' => '$48,290', 'change' => '+8%', 'trend' => 'up', 'icon' => 'currency-dollar'],
    ['label' => 'Orders', 'value' => '1,204', 'change' => '-3%', 'trend' => 'down', 'icon' => 'shopping-cart'],
    ['label' => 'Page Views', 'value' => '89.2K', 'change' => '+23%', 'trend' => 'up', 'icon' => 'eye'],
];
$sections = $sections ?: ['Dashboard', 'Users', 'Settings', 'Analytics', 'Security', 'Logs'];
?>

<div 
    class="gsmui-admin-panel {{ $class }}"
    x-data="gsmuiAdminPanel({
        stats: @js($stats),
        recentActivities: @js($recentActivities),
        users: @js($users),
        sections: @js($sections),
    })"
    id="{{ $id }}"
>
    <div class="flex h-full bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-56 lg:w-64 border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col flex-shrink-0">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center text-white font-bold text-sm">A</div>
                    <div>
                        <div class="font-semibold text-zinc-900 dark:text-white text-sm">Admin Panel</div>
                        <div class="text-xs text-zinc-500 dark:text-zinc-400">v1.0.0</div>
                    </div>
                </div>
            </div>
            <nav class="flex-1 overflow-y-auto p-3 space-y-0.5">
                <template x-for="section in sections" :key="section">
                    <button @click="activeSection = section"
                        class="flex items-center gap-2 w-full px-3 py-2 text-sm rounded-lg transition-colors"
                        :class="activeSection === section ? 'bg-primary/10 text-primary font-medium' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 hover:text-zinc-900 dark:hover:text-white'">
                        <span x-text="section"></span>
                    </button>
                </template>
            </nav>
            <div class="p-3 border-t border-zinc-200 dark:border-zinc-700">
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center text-sm font-medium">A</div>
                    <div class="text-sm"><div class="font-medium text-zinc-900 dark:text-white">Admin</div><div class="text-xs text-zinc-500">admin@example.com</div></div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="flex-1 overflow-y-auto p-6 space-y-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="activeSection"></h1>
                <div class="flex items-center gap-2">
                    <button class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors relative">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 rounded-full text-[10px] text-white flex items-center justify-center font-medium">3</span>
                    </button>
                </div>
            </div>

            <!-- Dashboard View -->
            <template x-if="activeSection === 'Dashboard'">
                <div class="space-y-6">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <template x-for="stat in stats" :key="stat.label">
                            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400" x-text="stat.label"></span>
                                    <span class="text-xs px-2 py-0.5 rounded-full font-medium"
                                        :class="stat.trend === 'up' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400'"
                                        x-text="stat.change">
                                    </span>
                                </div>
                                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="stat.value"></div>
                            </div>
                        </template>
                    </div>

                    <!-- Tables placeholder -->
                    <div class="p-6 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                        <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Activity</h3>
                        <div class="space-y-3">
                            <template x-for="i in 5" :key="i">
                                <div class="flex items-center gap-3 py-2 border-b border-zinc-100 dark:border-zinc-700 last:border-0">
                                    <div class="w-2 h-2 rounded-full bg-primary/50"></div>
                                    <div class="flex-1 text-sm text-zinc-600 dark:text-zinc-400">
                                        <span class="font-medium text-zinc-900 dark:text-white">User action</span> performed an activity
                                    </div>
                                    <span class="text-xs text-zinc-400">2h ago</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Generic section placeholder -->
            <template x-if="activeSection !== 'Dashboard'">
                <div class="p-12 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-center">
                    <svg class="w-16 h-16 mx-auto mb-3 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1" x-text="activeSection"></h3>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">This section is under development.</p>
                </div>
            </template>
        </main>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiAdminPanel', (config) => ({
        stats: config.stats,
        recentActivities: config.recentActivities,
        users: config.users,
        sections: config.sections,
        activeSection: 'Dashboard',
    }));
});
</script>
