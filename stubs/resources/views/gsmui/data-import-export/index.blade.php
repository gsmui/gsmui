@php
$classes = Gsmui::classes()
    ->add('flex flex-col gap-6')
    ->add('p-6')
    ->toArray();
@endphp

<div {{ $attributes->merge(['class' => $classes[0]]) }}
     x-data="dataImportExport()"
     x-init="init()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Data Import / Export</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Import and export your data in various formats</p>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 border-b border-zinc-200 dark:border-white/10">
        <button @click="tab = 'import'"
                :class="tab === 'import' ? 'border-b-2 border-(--color-accent) text-(--color-accent)' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                class="px-4 py-2 text-sm font-medium transition-colors">
            Import
        </button>
        <button @click="tab = 'export'"
                :class="tab === 'export' ? 'border-b-2 border-(--color-accent) text-(--color-accent)' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                class="px-4 py-2 text-sm font-medium transition-colors">
            Export
        </button>
        <button @click="tab = 'history'"
                :class="tab === 'history' ? 'border-b-2 border-(--color-accent) text-(--color-accent)' : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300'"
                class="px-4 py-2 text-sm font-medium transition-colors">
            History
        </button>
    </div>

    {{-- Import Tab --}}
    <div x-show="tab === 'import'" x-cloak class="space-y-6">
        <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-6">
            <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-4">Upload File</h3>
            <div @dragover.prevent="dragOver = true"
                 @dragleave.prevent="dragOver = false"
                 @drop.prevent="handleDrop($event)"
                 :class="dragOver ? 'border-(--color-accent) bg-(--color-accent)/5' : 'border-zinc-300 dark:border-zinc-600'"
                 class="border-2 border-dashed rounded-lg p-8 text-center transition-colors cursor-pointer"
                 @click="$refs.fileInput.click()">
                <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" accept=".csv,.xlsx,.xls,.json" class="hidden">
                <template x-if="!file">
                    <div>
                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">
                            <span class="font-medium text-(--color-accent)">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500">CSV, XLSX, XLS, or JSON (max 10MB)</p>
                    </div>
                </template>
                <template x-if="file">
                    <div>
                        <svg class="mx-auto h-12 w-12 text-(--color-accent)" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm font-medium text-zinc-900 dark:text-white" x-text="file.name"></p>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500" x-text="(file.size / 1024).toFixed(1) + ' KB'"></p>
                        <button @click="file = null; preview = null" class="mt-2 text-xs text-red-500 hover:text-red-700">Remove</button>
                    </div>
                </template>
            </div>
        </div>

        <template x-if="file">
            <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-6 space-y-4">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Import Settings</h3>
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Data Type</label>
                    <select x-model="importType" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white">
                        <option value="users">Users</option>
                        <option value="products">Products</option>
                        <option value="orders">Orders</option>
                        <option value="customers">Customers</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Import Strategy</label>
                    <select x-model="importStrategy" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white">
                        <option value="skip">Skip existing</option>
                        <option value="overwrite">Overwrite existing</option>
                        <option value="merge">Merge</option>
                    </select>
                </div>
                <div class="flex items-start gap-2">
                    <input type="checkbox" x-model="hasHeader" class="mt-1 rounded border-zinc-300 dark:border-zinc-600">
                    <label class="text-sm text-zinc-600 dark:text-zinc-400">First row contains column headers</label>
                </div>

                <template x-if="preview">
                    <div>
                        <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-2">Preview</h4>
                        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-white/10">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-zinc-50 dark:bg-zinc-700">
                                        <template x-for="col in preview.headers" :key="col">
                                            <th class="px-3 py-2 text-left font-medium text-zinc-600 dark:text-zinc-300 border-r border-zinc-200 dark:border-white/10 last:border-r-0" x-text="col"></th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(row, i) in preview.rows" :key="i">
                                        <tr :class="i % 2 === 0 ? 'bg-white dark:bg-zinc-800' : 'bg-zinc-50 dark:bg-zinc-700/50'">
                                            <template x-for="(cell, j) in row" :key="j">
                                                <td class="px-3 py-1.5 text-zinc-700 dark:text-zinc-300 border-r border-zinc-200 dark:border-white/10 last:border-r-0" x-text="cell"></td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        <p class="mt-1 text-xs text-zinc-400" x-text="'Showing ' + preview.rows.length + ' of ' + preview.total + ' rows'"></p>
                    </div>
                </template>

                <div class="flex gap-2 pt-2">
                    <button @click="previewData()" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-200 dark:border-white/10 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Preview</button>
                    <button @click="importData()"
                            :disabled="importing"
                            class="px-4 py-2 text-sm font-medium rounded-lg bg-(--color-accent) text-white hover:opacity-90 transition-opacity disabled:opacity-50">
                        <span x-show="!importing">Import Data</span>
                        <span x-show="importing" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                            Importing...
                        </span>
                    </button>
                </div>

                <template x-if="importResult">
                    <div :class="importResult.success ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800'"
                         class="rounded-lg border p-3 text-sm">
                        <p :class="importResult.success ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300'" x-text="importResult.message"></p>
                        <template x-if="importResult.errors && importResult.errors.length">
                            <ul class="mt-1 list-disc list-inside text-red-600 dark:text-red-400 text-xs">
                                <template x-for="err in importResult.errors" :key="err">
                                    <li x-text="err"></li>
                                </template>
                            </ul>
                        </template>
                    </div>
                </template>
            </div>
        </template>
    </div>

    {{-- Export Tab --}}
    <div x-show="tab === 'export'" x-cloak class="space-y-6">
        <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 p-6 space-y-4">
            <h3 class="text-sm font-medium text-zinc-900 dark:text-white">Export Settings</h3>
            <div>
                <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Data Type</label>
                <select x-model="exportType" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white">
                    <option value="users">Users</option>
                    <option value="products">Products</option>
                    <option value="orders">Orders</option>
                    <option value="customers">Customers</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Format</label>
                <div class="flex gap-3">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="exportFormat" value="csv" class="text-(--color-accent) focus:ring-(--color-accent)">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">CSV</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="exportFormat" value="xlsx" class="text-(--color-accent) focus:ring-(--color-accent)">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">Excel (XLSX)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="exportFormat" value="json" class="text-(--color-accent) focus:ring-(--color-accent)">
                        <span class="text-sm text-zinc-700 dark:text-zinc-300">JSON</span>
                    </label>
                </div>
            </div>
            <div>
                <label class="block text-sm text-zinc-600 dark:text-zinc-400 mb-1">Filter (optional)</label>
                <input type="text" x-model="exportFilter" placeholder="e.g. status=active" class="w-full rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder-zinc-400">
            </div>
            <div class="flex items-start gap-2">
                <input type="checkbox" x-model="exportIncludeHeaders" class="mt-1 rounded border-zinc-300 dark:border-zinc-600">
                <label class="text-sm text-zinc-600 dark:text-zinc-400">Include column headers</label>
            </div>

            <div class="flex gap-2 pt-2">
                <button @click="previewExport()"
                        class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-200 dark:border-white/10 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">Preview</button>
                <button @click="exportData()"
                        :disabled="exporting"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-(--color-accent) text-white hover:opacity-90 transition-opacity disabled:opacity-50">
                    <span x-show="!exporting">Export</span>
                    <span x-show="exporting" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        Exporting...
                    </span>
                </button>
            </div>

            <template x-if="exportResult">
                <div :class="exportResult.success ? 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800'"
                     class="rounded-lg border p-3 text-sm">
                    <p :class="exportResult.success ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300'" x-text="exportResult.message"></p>
                    <template x-if="exportResult.success && exportResult.downloadUrl">
                        <a :href="exportResult.downloadUrl" class="mt-2 inline-block text-(--color-accent) hover:underline text-xs">Download file</a>
                    </template>
                </div>
            </template>
        </div>
    </div>

    {{-- History Tab --}}
    <div x-show="tab === 'history'" x-cloak>
        <div class="rounded-xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800">
            <div class="p-4 border-b border-zinc-200 dark:border-white/10">
                <div class="flex items-center gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" x-model="historySearch" placeholder="Search history..." class="w-full pl-10 pr-4 py-2 text-sm rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white placeholder-zinc-400">
                    </div>
                    <select x-model="historyFilter" class="rounded-lg border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white">
                        <option value="all">All</option>
                        <option value="import">Imports</option>
                        <option value="export">Exports</option>
                    </select>
                </div>
            </div>
            <div class="divide-y divide-zinc-200 dark:divide-white/10">
                <template x-for="entry in filteredHistory" :key="entry.id">
                    <div class="p-4 flex items-center justify-between hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <template x-if="entry.type === 'import'">
                                <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </template>
                            <template x-if="entry.type === 'export'">
                                <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </template>
                            <div>
                                <p class="text-sm font-medium text-zinc-900 dark:text-white capitalize" x-text="entry.type + ': ' + entry.dataType"></p>
                                <p class="text-xs text-zinc-400" x-text="entry.date + ' · ' + entry.records + ' records'"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span :class="entry.status === 'success' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : entry.status === 'failed' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300'"
                                  class="px-2 py-0.5 text-xs font-medium rounded-full capitalize" x-text="entry.status"></span>
                            <button @click="downloadHistoryEntry(entry)" x-show="entry.file" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
                <template x-if="filteredHistory.length === 0">
                    <div class="p-8 text-center text-sm text-zinc-400">No history found</div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function dataImportExport() {
            return {
                tab: 'import',
                // Import
                file: null,
                dragOver: false,
                importType: 'users',
                importStrategy: 'skip',
                hasHeader: true,
                preview: null,
                importing: false,
                importResult: null,
                // Export
                exportType: 'users',
                exportFormat: 'csv',
                exportFilter: '',
                exportIncludeHeaders: true,
                exporting: false,
                exportResult: null,
                // History
                historySearch: '',
                historyFilter: 'all',
                history: [
                    { id: 1, type: 'import', dataType: 'users', date: '2026-07-15 14:32', records: 245, status: 'success', file: 'users-import-20260715.csv' },
                    { id: 2, type: 'export', dataType: 'products', date: '2026-07-14 09:15', records: 89, status: 'success', file: 'products-export-20260714.xlsx' },
                    { id: 3, type: 'import', dataType: 'orders', date: '2026-07-13 16:45', records: 0, status: 'failed', file: null },
                    { id: 4, type: 'export', dataType: 'customers', date: '2026-07-12 11:00', records: 512, status: 'success', file: 'customers-export-20260712.csv' },
                ],

                get filteredHistory() {
                    let items = this.history;
                    if (this.historyFilter !== 'all') {
                        items = items.filter(e => e.type === this.historyFilter);
                    }
                    if (this.historySearch) {
                        const q = this.historySearch.toLowerCase();
                        items = items.filter(e => e.dataType.toLowerCase().includes(q) || e.status.toLowerCase().includes(q));
                    }
                    return items;
                },

                handleDrop(event) {
                    this.dragOver = false;
                    const f = event.dataTransfer.files[0];
                    if (f) this.file = f;
                },

                handleFileSelect(event) {
                    const f = event.target.files[0];
                    if (f) this.file = f;
                },

                previewData() {
                    if (!this.file) return;
                    this.preview = {
                        headers: ['Name', 'Email', 'Role', 'Status'],
                        rows: [
                            ['John Doe', 'john@example.com', 'Admin', 'Active'],
                            ['Jane Smith', 'jane@example.com', 'Editor', 'Active'],
                            ['Bob Johnson', 'bob@example.com', 'Viewer', 'Inactive'],
                        ],
                        total: 245
                    };
                },

                importData() {
                    if (!this.file) return;
                    this.importing = true;
                    this.importResult = null;
                    setTimeout(() => {
                        this.importing = false;
                        this.importResult = {
                            success: true,
                            message: 'Successfully imported 245 records. 3 duplicates skipped.',
                            errors: []
                        };
                        this.history.unshift({
                            id: Date.now(),
                            type: 'import',
                            dataType: this.importType,
                            date: new Date().toLocaleString(),
                            records: 245,
                            status: 'success',
                            file: this.file.name
                        });
                    }, 2000);
                },

                previewExport() {
                    this.exportResult = null;
                    const count = { users: 245, products: 89, orders: 156, customers: 512 }[this.exportType] || 0;
                    this.exportResult = {
                        success: true,
                        message: 'Preview: ' + count + ' records will be exported in ' + this.exportFormat.toUpperCase() + ' format.'
                    };
                },

                exportData() {
                    this.exporting = true;
                    this.exportResult = null;
                    setTimeout(() => {
                        this.exporting = false;
                        this.exportResult = {
                            success: true,
                            message: 'Export completed successfully.',
                            downloadUrl: '#'
                        };
                        const count = { users: 245, products: 89, orders: 156, customers: 512 }[this.exportType] || 0;
                        this.history.unshift({
                            id: Date.now(),
                            type: 'export',
                            dataType: this.exportType,
                            date: new Date().toLocaleString(),
                            records: count,
                            status: 'success',
                            file: this.exportType + '-export.' + this.exportFormat
                        });
                    }, 2000);
                },

                downloadHistoryEntry(entry) {
                    alert('Downloading: ' + entry.file);
                }
            }
        }
    </script>
</div>
