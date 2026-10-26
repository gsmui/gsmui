@props([
    'tasks' => [],
    'class' => '',
])

<?php
$id = 'scheduled-tasks-' . uniqid();
$tasks = $tasks ?: [
    ['id' => 1, 'command' => 'backup:run --type=full', 'description' => 'Full system backup', 'frequency' => '0 3 * * *', 'status' => 'active', 'last_run' => '2024-01-15 03:00', 'next_run' => '2024-01-16 03:00', 'avg_duration' => '2m 34s'],
    ['id' => 2, 'command' => 'queue:work --max-jobs=100', 'description' => 'Process job queue', 'frequency' => '*/5 * * * *', 'status' => 'active', 'last_run' => '2024-01-15 14:30', 'next_run' => '2024-01-15 14:35', 'avg_duration' => '45s'],
    ['id' => 3, 'command' => 'cache:clear --tags=views', 'description' => 'Clear view cache', 'frequency' => '0 */6 * * *', 'status' => 'paused', 'last_run' => '2024-01-15 06:00', 'next_run' => '-', 'avg_duration' => '12s'],
    ['id' => 4, 'command' => 'report:generate --daily', 'description' => 'Generate daily report', 'frequency' => '0 8 * * *', 'status' => 'active', 'last_run' => '2024-01-15 08:00', 'next_run' => '2024-01-16 08:00', 'avg_duration' => '1m 20s'],
    ['id' => 5, 'command' => 'session:cleanup', 'description' => 'Clean expired sessions', 'frequency' => '0 2 * * *', 'status' => 'inactive', 'last_run' => '2024-01-10 02:00', 'next_run' => '-', 'avg_duration' => '8s'],
];
$frequencies = ['* * * * *' => 'Every minute', '*/5 * * * *' => 'Every 5 minutes', '0 * * * *' => 'Hourly', '0 */6 * * *' => 'Every 6 hours', '0 8 * * *' => 'Daily at 8 AM', '0 3 * * *' => 'Daily at 3 AM', '0 0 * * 0' => 'Weekly'];
?>

<div 
    class="gsmui-scheduled-tasks {{ $class }}"
    x-data="gsmuiScheduledTasks({
        tasks: @js($tasks),
        frequencies: @js($frequencies),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div><h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Scheduled Tasks</h2><p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage cron jobs and scheduled commands.</p></div>
            <button @click="showAddTask = true" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ Add Task</button>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold" x-text="tasks.length"></div><div class="text-sm text-zinc-500">Total Tasks</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold text-emerald-600" x-text="tasks.filter(t => t.status === 'active').length"></div><div class="text-sm text-zinc-500">Active</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold text-amber-600" x-text="tasks.filter(t => t.status === 'paused').length"></div><div class="text-sm text-zinc-500">Paused</div></div>
            <div class="p-4 rounded-xl border border-zinc-200 bg-white dark:bg-zinc-800"><div class="text-2xl font-bold text-red-500" x-text="tasks.filter(t => t.status === 'inactive').length"></div><div class="text-sm text-zinc-500">Inactive</div></div>
        </div>

        <div class="space-y-3">
            <template x-for="task in tasks" :key="task.id">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full" :class="{'bg-emerald-500': task.status === 'active', 'bg-amber-500': task.status === 'paused', 'bg-zinc-400': task.status === 'inactive'}"></div>
                                <h3 class="font-medium text-zinc-900 dark:text-white" x-text="task.description"></h3>
                                <span class="text-xs px-2 py-0.5 rounded-full capitalize font-medium"
                                    :class="{'bg-emerald-100 text-emerald-700': task.status === 'active', 'bg-amber-100 text-amber-700': task.status === 'paused', 'bg-zinc-100 text-zinc-600': task.status === 'inactive'}"
                                    x-text="task.status">
                                </span>
                            </div>
                            <code class="block text-xs font-mono text-zinc-500 dark:text-zinc-400 mt-1" x-text="task.command"></code>
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <span><span class="text-zinc-400">Cron:</span> <code class="font-mono" x-text="task.frequency"></code> <span class="text-zinc-400" x-text="'(' + (frequencies[task.frequency] || 'Custom') + ')'"></span></span>
                                <span><span class="text-zinc-400">Last:</span> <span x-text="task.last_run"></span></span>
                                <span><span class="text-zinc-400">Next:</span> <span x-text="task.next_run"></span></span>
                                <span><span class="text-zinc-400">Duration:</span> <span x-text="task.avg_duration"></span></span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 ml-4 flex-shrink-0">
                            <button @click="runTask(task)" class="px-3 py-1 text-xs border border-zinc-300 dark:border-zinc-600 rounded-lg hover:bg-zinc-50 transition-colors" :disabled="task.running">
                                <span x-text="task.running ? 'Running...' : 'Run Now'"></span>
                            </button>
                            <button @click="toggleTask(task)" class="relative w-9 h-4.5 rounded-full transition-colors" :class="task.status === 'active' ? 'bg-primary' : 'bg-zinc-300 dark:bg-zinc-600'">
                                <div class="absolute w-3.5 h-3.5 bg-white rounded-full shadow top-0.5 transition-transform" :class="task.status === 'active' ? 'translate-x-[18px]' : 'translate-x-0.5'"></div>
                            </button>
                            <button @click="editTask(task)" class="p-1 text-zinc-400 hover:text-primary"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button @click="deleteTask(task)" class="p-1 text-zinc-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Add/Edit Modal -->
        <template x-if="showAddTask">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="showAddTask = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-lg w-full p-6">
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4" x-text="editingTask ? 'Edit Task' : 'New Scheduled Task'"></h3>
                    <div class="space-y-3">
                        <div><label class="block text-sm font-medium mb-1">Description</label><input type="text" x-model="form.description" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                        <div><label class="block text-sm font-medium mb-1">Command</label><input type="text" x-model="form.command" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" placeholder="php artisan command:name" /></div>
                        <div><label class="block text-sm font-medium mb-1">Frequency</label><select x-model="form.frequency" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><template x-for="(label, cron) in frequencies" :key="cron"><option :value="cron" x-text="label"></option></template></select></div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button @click="showAddTask = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="saveTask" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Save</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiScheduledTasks', (config) => ({
        tasks: config.tasks, frequencies: config.frequencies,
        showAddTask: false, editingTask: null,
        form: { description: '', command: '', frequency: '0 3 * * *' },

        toggleTask(task) { task.status = task.status === 'active' ? 'paused' : task.status === 'paused' ? 'active' : 'active'; },
        runTask(task) { task.running = true; setTimeout(() => { task.running = false; task.last_run = new Date().toISOString().replace('T',' ').slice(0,16); }, 2000); },
        editTask(task) { this.editingTask = task; this.form = { description: task.description, command: task.command, frequency: task.frequency }; this.showAddTask = true; },
        deleteTask(task) { this.tasks = this.tasks.filter(t => t.id !== task.id); },
        saveTask() {
            if (this.editingTask) { Object.assign(this.editingTask, this.form); }
            else { this.tasks.push({ id: Date.now(), ...this.form, status: 'active', last_run: '-', next_run: '-', avg_duration: '-' }); }
            this.showAddTask = false; this.editingTask = null;
            this.form = { description: '', command: '', frequency: '0 3 * * *' };
        },
    }));
});
</script>
