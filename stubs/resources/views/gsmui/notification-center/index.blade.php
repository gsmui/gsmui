@props([
    'notifications' => [],
    'unreadCount' => 0,
    'class' => '',
])

<?php
$id = 'notification-center-' . uniqid();
$notifications = $notifications ?: [
    ['id' => 1, 'type' => 'info', 'title' => 'New user registered', 'message' => 'John Doe created an account.', 'time' => '5m ago', 'read' => false],
    ['id' => 2, 'type' => 'success', 'title' => 'Payment received', 'message' => '$29.00 payment for Pro plan.', 'time' => '1h ago', 'read' => false],
    ['id' => 3, 'type' => 'warning', 'title' => 'Server alert', 'message' => 'CPU usage exceeded 90%.', 'time' => '3h ago', 'read' => true],
    ['id' => 4, 'type' => 'error', 'title' => 'Failed job', 'message' => 'SendEmail job failed after 3 attempts.', 'time' => '1d ago', 'read' => true],
    ['id' => 5, 'type' => 'info', 'title' => 'Weekly report ready', 'message' => 'Your analytics report is available.', 'time' => '2d ago', 'read' => true],
];
?>

<div 
    class="gsmui-notification-center {{ $class }}"
    x-data="gsmuiNotificationCenter({
        notifications: @js($notifications),
    })"
    id="{{ $id }}"
>
    <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Notifications</h3>
                <span class="text-xs px-2 py-0.5 rounded-full bg-primary/10 text-primary font-medium" x-text="unreadCount + ' unread'"></span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="markAllRead" x-show="unreadCount > 0" class="text-sm text-primary hover:underline">Mark all read</button>
                <button @click="showFilters = !showFilters" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                </button>
            </div>
        </div>

        <template x-if="showFilters">
            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900/50 flex items-center gap-3">
                <template x-for="f in ['all', 'unread', 'info', 'success', 'warning', 'error']" :key="f">
                    <button @click="filter = f" class="px-3 py-1 text-xs rounded-full capitalize transition-colors"
                        :class="filter === f ? 'bg-primary text-white' : 'bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-700'"
                        x-text="f">
                    </button>
                </template>
            </div>
        </template>

        <div class="divide-y divide-zinc-200 dark:divide-zinc-700 max-h-[500px] overflow-y-auto">
            <template x-for="notification in filteredNotifications" :key="notification.id">
                <div class="p-4 transition-colors cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
                    :class="{ 'bg-primary/[0.02] dark:bg-primary/[0.02]': !notification.read }"
                    @click="markRead(notification)">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                            :class="{
                                'bg-blue-100 dark:bg-blue-900/30 text-blue-600': notification.type === 'info',
                                'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600': notification.type === 'success',
                                'bg-amber-100 dark:bg-amber-900/30 text-amber-600': notification.type === 'warning',
                                'bg-red-100 dark:bg-red-900/30 text-red-600': notification.type === 'error',
                            }">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                x-show="notification.type === 'info'" x-transition><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                x-show="notification.type === 'success'" x-transition><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                x-show="notification.type === 'warning'" x-transition><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                x-show="notification.type === 'error'" x-transition><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <div class="font-medium text-sm text-zinc-900 dark:text-white" :class="{ 'font-semibold': !notification.read }" x-text="notification.title"></div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <template x-if="!notification.read">
                                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                                    </template>
                                    <span class="text-xs text-zinc-400" x-text="notification.time"></span>
                                </div>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5 line-clamp-2" x-text="notification.message"></p>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="filteredNotifications.length === 0">
                <div class="p-8 text-center text-zinc-500 dark:text-zinc-400">
                    <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <p>No notifications</p>
                </div>
            </template>
        </div>

        <div class="p-3 border-t border-zinc-200 dark:border-zinc-700 text-center">
            <button @click="clearAll" class="text-sm text-zinc-500 dark:text-zinc-400 hover:text-red-500 transition-colors">Clear all notifications</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiNotificationCenter', (config) => ({
        notifications: config.notifications,
        filter: 'all',
        showFilters: false,

        get unreadCount() {
            return this.notifications.filter(n => !n.read).length;
        },

        get filteredNotifications() {
            if (this.filter === 'all') return this.notifications;
            if (this.filter === 'unread') return this.notifications.filter(n => !n.read);
            return this.notifications.filter(n => n.type === this.filter);
        },

        markRead(notification) {
            notification.read = true;
        },

        markAllRead() {
            this.notifications.forEach(n => n.read = true);
        },

        clearAll() {
            this.notifications = [];
        },
    }));
});
</script>
