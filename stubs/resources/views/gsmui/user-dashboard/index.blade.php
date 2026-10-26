@props([
    'user' => [],
    'stats' => [],
    'recentActivity' => [],
    'notifications' => [],
    'class' => '',
])

<?php
$id = 'user-dashboard-' . uniqid();
$user = $user ?: ['name' => 'John Doe', 'email' => 'john@example.com', 'avatar' => '', 'role' => 'Developer', 'joined' => 'Jan 2024'];
$stats = $stats ?: [
    ['label' => 'Projects', 'value' => '12', 'icon' => 'folder'],
    ['label' => 'Tasks', 'value' => '48', 'icon' => 'check-circle'],
    ['label' => 'Completed', 'value' => '36', 'icon' => 'check-badge'],
    ['label' => 'Contributions', 'value' => '156', 'icon' => 'fire'],
];
?>

<div 
    class="gsmui-user-dashboard {{ $class }}"
    x-data="gsmuiUserDashboard({
        user: @js($user),
        stats: @js($stats),
        recentActivity: @js($recentActivity),
        notifications: @js($notifications),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Welcome Header -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary/10 via-primary/5 to-zinc-100 dark:from-primary/20 dark:via-primary/10 dark:to-zinc-800 p-6 sm:p-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center text-2xl font-bold text-primary flex-shrink-0" x-text="user.name[0]"></div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Welcome back, <span x-text="user.name.split(' ')[0]"></span>!</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1" x-text="user.role + ' · Joined ' + user.joined"></p>
                </div>
                <button class="px-4 py-2 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg text-sm hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Edit Profile</button>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <template x-for="stat in stats" :key="stat.label">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="stat.value"></div>
                    <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1" x-text="stat.label"></div>
                </div>
            </template>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Activity Feed -->
            <div class="lg:col-span-2 p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Recent Activity</h3>
                <div class="space-y-4">
                    <template x-for="i in 6" :key="i">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-zinc-700 dark:text-zinc-300">You <span class="font-medium">updated</span> a project</p>
                                <p class="text-xs text-zinc-400 mt-0.5">2 hours ago</p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Notifications / Profile Card -->
            <div class="space-y-4">
                <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Profile</h3>
                    <div class="space-y-3 text-sm">
                        <div><span class="text-zinc-500 dark:text-zinc-400">Name:</span> <span class="text-zinc-900 dark:text-white ml-2" x-text="user.name"></span></div>
                        <div><span class="text-zinc-500 dark:text-zinc-400">Email:</span> <span class="text-zinc-900 dark:text-white ml-2" x-text="user.email"></span></div>
                        <div><span class="text-zinc-500 dark:text-zinc-400">Role:</span> <span class="text-zinc-900 dark:text-white ml-2" x-text="user.role"></span></div>
                        <div><span class="text-zinc-500 dark:text-zinc-400">Joined:</span> <span class="text-zinc-900 dark:text-white ml-2" x-text="user.joined"></span></div>
                    </div>
                </div>
                <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <h3 class="font-semibold text-zinc-900 dark:text-white mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <button class="w-full px-4 py-2 bg-primary text-white text-sm rounded-lg hover:bg-primary/90 transition-colors">New Project</button>
                        <button class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-sm rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">View Settings</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiUserDashboard', (config) => ({
        user: config.user,
        stats: config.stats,
        recentActivity: config.recentActivity,
        notifications: config.notifications,
    }));
});
</script>
