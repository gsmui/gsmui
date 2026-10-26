@props([
    'events' => [],
    'listeners' => [],
    'class' => '',
])

<?php
$id = 'events-system-' . uniqid();
$events = $events ?: [
    ['name' => 'App\\Events\\UserRegistered', 'listeners' => 2, 'queued' => true, 'times_fired' => 142],
    ['name' => 'App\\Events\\OrderPlaced', 'listeners' => 3, 'queued' => true, 'times_fired' => 89],
    ['name' => 'App\\Events\\PaymentReceived', 'listeners' => 1, 'queued' => false, 'times_fired' => 245],
    ['name' => 'App\\Events\\UserDeleted', 'listeners' => 2, 'queued' => true, 'times_fired' => 12],
];
$listeners = $listeners ?: [
    ['event' => 'UserRegistered', 'listener' => 'SendWelcomeEmail', 'queued' => true, 'priority' => 10],
    ['event' => 'UserRegistered', 'listener' => 'CreateDefaultSettings', 'queued' => false, 'priority' => 20],
    ['event' => 'OrderPlaced', 'listener' => 'ProcessPayment', 'queued' => true, 'priority' => 10],
];
?>

<div 
    class="gsmui-events-system {{ $class }}"
    x-data="gsmuiEventsSystem({
        events: @js($events),
        listeners: @js($listeners),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Events System</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitor and manage application events and listeners.</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="events.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Events</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-zinc-900 dark:text-white" x-text="listeners.length"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Listeners</div>
            </div>
            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="text-2xl font-bold text-emerald-600" x-text="events.reduce((s, e) => s + e.times_fired, 0)"></div>
                <div class="text-sm text-zinc-500 dark:text-zinc-400">Times Fired</div>
            </div>
        </div>

        <!-- Events Table -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Registered Events</h3>
            </div>
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Event</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Listeners</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Queued</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Times Fired</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="event in events" :key="event.name">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-900 dark:text-white" x-text="event.name"></code></td>
                            <td class="px-4 py-3 text-center text-sm text-zinc-600 dark:text-zinc-400" x-text="event.listeners"></td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xs px-2 py-0.5 rounded-full" :class="event.queued ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400'" x-text="event.queued ? 'Yes' : 'No'"></span>
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-zinc-900 dark:text-white" x-text="event.times_fired.toLocaleString()"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Listeners Table -->
        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 overflow-hidden">
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white">Registered Listeners</h3>
            </div>
            <table class="w-full">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Event</th>
                        <th class="text-left px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Listener</th>
                        <th class="text-center px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Queued</th>
                        <th class="text-right px-4 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wider">Priority</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <template x-for="listener in listeners" :key="listener.listener">
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-3 text-sm text-zinc-600 dark:text-zinc-400" x-text="listener.event"></td>
                            <td class="px-4 py-3"><code class="text-sm font-mono text-zinc-900 dark:text-white" x-text="listener.listener"></code></td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-xs px-2 py-0.5 rounded-full" :class="listener.queued ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700' : 'bg-zinc-100 dark:bg-zinc-700 text-zinc-600'" x-text="listener.queued ? 'Yes' : 'No'"></span>
                            </td>
                            <td class="px-4 py-3 text-right text-sm text-zinc-600 dark:text-zinc-400" x-text="listener.priority"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Dispatch Simulator -->
        <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
            <h3 class="font-semibold text-zinc-900 dark:text-white mb-3">Dispatch Event (Simulator)</h3>
            <div class="flex items-center gap-3">
                <select x-model="dispatchEvent" class="flex-1 px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700">
                    <option value="">Select event...</option>
                    <template x-for="event in events" :key="event.name">
                        <option :value="event.name" x-text="event.name.split('\\').pop()"></option>
                    </template>
                </select>
                <button @click="simulateDispatch" :disabled="!dispatchEvent" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90 disabled:opacity-50 transition-colors">Dispatch</button>
            </div>
            <template x-if="dispatchResult">
                <div class="mt-3 text-sm text-emerald-600 dark:text-emerald-400" x-text="dispatchResult"></div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiEventsSystem', (config) => ({
        events: config.events,
        listeners: config.listeners,
        dispatchEvent: '',
        dispatchResult: '',

        simulateDispatch() {
            if (!this.dispatchEvent) return;
            const event = this.events.find(e => e.name === this.dispatchEvent || e.name.endsWith('\\' + this.dispatchEvent));
            if (event) {
                event.times_fired++;
                this.dispatchResult = `Dispatched ${this.dispatchEvent} — ${event.listeners} listener(s) notified.`;
            } else {
                this.dispatchResult = `Event "${this.dispatchEvent}" not found.`;
            }
            setTimeout(() => { this.dispatchResult = ''; }, 3000);
        },
    }));
});
</script>
