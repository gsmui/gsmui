@props([
    'templates' => [],
    'class' => '',
])

<?php
$id = 'email-templates-' . uniqid();
$templates = $templates ?: [
    ['id' => 1, 'name' => 'Welcome Email', 'subject' => 'Welcome to {{ app.name }}!', 'category' => 'Onboarding', 'updated' => '2024-01-15', 'variables' => ['user.name', 'app.name']],
    ['id' => 2, 'name' => 'Password Reset', 'subject' => 'Reset your password', 'category' => 'Auth', 'updated' => '2024-01-10', 'variables' => ['user.name', 'reset_link']],
    ['id' => 3, 'name' => 'Invoice Receipt', 'subject' => 'Your invoice from {{ app.name }}', 'category' => 'Billing', 'updated' => '2024-01-05', 'variables' => ['user.name', 'invoice.total', 'invoice.date']],
    ['id' => 4, 'name' => 'Weekly Digest', 'subject' => 'Your weekly summary', 'category' => 'Notifications', 'updated' => '2024-01-01', 'variables' => ['user.name', 'stats.views', 'stats.users']],
];
?>

<div 
    class="gsmui-email-templates {{ $class }}"
    x-data="gsmuiEmailTemplates({
        templates: @js($templates),
    })"
    id="{{ $id }}"
>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-zinc-900 dark:text-white">Email Templates</h2>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Manage transactional email templates.</p>
            </div>
            <button @click="openEditor(null)" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">+ New Template</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <template x-for="tpl in templates" :key="tpl.id">
                <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md transition-shadow cursor-pointer group" @click="openEditor(tpl)">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-zinc-900 dark:text-white" x-text="tpl.name"></h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5 font-mono text-xs" x-text="tpl.subject"></p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-zinc-100 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400 flex-shrink-0 ml-2" x-text="tpl.category"></span>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        <template x-for="v in tpl.variables" :key="v">
                            <code class="text-xs px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded text-zinc-600 dark:text-zinc-400" x-text="'{{' + v + '}}'"></code>
                        </template>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-zinc-100 dark:border-zinc-700">
                        <span class="text-xs text-zinc-400" x-text="'Updated ' + tpl.updated"></span>
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click.stop="duplicateTemplate(tpl)" class="p-1 text-zinc-400 hover:text-primary" title="Duplicate">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                            <button @click.stop="deleteTemplate(tpl)" class="p-1 text-zinc-400 hover:text-red-500" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M10 7v10m4-10v10m-6-10h10"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Editor Modal -->
        <template x-if="editorOpen">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/20" @click.self="editorOpen = false">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                    <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white" x-text="editingTemplate ? 'Edit Template' : 'New Template'"></h3>
                        <button @click="editorOpen = false" class="p-1 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="block text-sm font-medium mb-1">Name</label><input type="text" x-model="form.name" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm" /></div>
                            <div><label class="block text-sm font-medium mb-1">Category</label><select x-model="form.category" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm"><option>Onboarding</option><option>Auth</option><option>Billing</option><option>Notifications</option></select></div>
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Subject</label><input type="text" x-model="form.subject" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono" /></div>
                        <div><label class="block text-sm font-medium mb-1">HTML Body</label><textarea x-model="form.body" rows="12" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-primary"></textarea></div>
                    </div>
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3">
                        <button @click="editorOpen = false" class="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm">Cancel</button>
                        <button @click="saveTemplate" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary/90">Save Template</button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiEmailTemplates', (config) => ({
        templates: config.templates,
        editorOpen: false,
        editingTemplate: null,
        form: { name: '', subject: '', category: 'Notifications', body: '' },

        openEditor(tpl) {
            this.editingTemplate = tpl;
            this.form = tpl ? { ...tpl } : { name: '', subject: '', category: 'Notifications', body: '<!DOCTYPE html>\n<html>\n<body>\n  <h1>@{{ title }}</h1>\n  <p>@{{ content }}</p>\n</body>\n</html>' };
            this.editorOpen = true;
        },

        saveTemplate() {
            if (this.editingTemplate) {
                Object.assign(this.editingTemplate, this.form);
            } else {
                this.form.id = Date.now();
                this.form.updated = new Date().toISOString().slice(0, 10);
                this.form.variables = ['user.name'];
                this.templates.push({ ...this.form });
            }
            this.editorOpen = false;
        },

        duplicateTemplate(tpl) {
            this.templates.push({ ...tpl, id: Date.now(), name: tpl.name + ' (Copy)' });
        },

        deleteTemplate(tpl) {
            this.templates = this.templates.filter(t => t.id !== tpl.id);
        },
    }));
});
</script>
