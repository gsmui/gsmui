@props([
    'columns' => [],
    'rows' => [],
    'total' => null,
    'perPage' => 25,
    'page' => 1,
    'sortBy' => null,
    'sortDirection' => 'asc',
    'filters' => [],
    'search' => '',
    'groupBy' => null,
    'selectable' => true,
    'editable' => false,
    'resizableColumns' => true,
    'freezeColumns' => 0,
    'stickyHeader' => true,
    'exportable' => true,
    'importable' => false,
    'serverSide' => false,
    'loading' => false,
    'emptyMessage' => 'No data available',
    'class' => '',
])

<?php
$id = 'datagrid-pro-' . uniqid();
?>

<div 
    class="gsmui-datagrid-pro {{ $class }}"
    x-data="gsmuiDataGridPro({
        columns: @js($columns),
        rows: @js($rows),
        total: @js($total ?? count($rows)),
        perPage: @js($perPage),
        page: @js($page),
        sortBy: @js($sortBy),
        sortDirection: @js($sortDirection),
        groupBy: @js($groupBy),
        selectable: @js($selectable),
        editable: @js($editable),
        resizableColumns: @js($resizableColumns),
        freezeColumns: @js($freezeColumns),
        stickyHeader: @js($stickyHeader),
        serverSide: @js($serverSide),
    })"
    id="{{ $id }}"
    role="grid"
    aria-label="Data grid pro"
>
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        
        <!-- Toolbar -->
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 space-y-3">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 min-w-0">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input 
                            type="search"
                            x-model.debounce.300ms="search"
                            @keydown.enter.prevent="searchTable()"
                            class="w-full pl-10 pr-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                            placeholder="Search..."
                            aria-label="Search"
                        />
                    </div>
                </div>
                
                <div class="flex items-center gap-2 flex-shrink-0">
                    <select 
                        x-model="perPage"
                        @change="page = 1; fetchData()"
                        class="px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                        aria-label="Rows per page"
                    >
                        <option value="10">10 / page</option>
                        <option value="25">25 / page</option>
                        <option value="50">50 / page</option>
                        <option value="100">100 / page</option>
                    </select>
                    
                    <template x-if="exportable">
                        <button @click="exportData('csv')" class="px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 text-sm transition-colors" title="Export CSV">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </button>
                    </template>
                    
                    <template x-if="importable">
                        <button @click="$refs.fileInput.click()" class="px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 text-sm transition-colors" title="Import CSV">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        </button>
                    </template>
                    <input type="file" accept=".csv,.json" class="hidden" x-ref="fileInput" @change="importData($event)" />
                    
                    <template x-if="selectable && selectedRowIds.length > 0">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400" x-text="selectedRowIds.length + ' selected'"></span>
                    </template>
                </div>
            </div>
            
            <!-- Group By selector -->
            <template x-if="groupableColumns.length > 0">
                <div class="flex items-center gap-2">
                    <span class="text-sm text-zinc-500 dark:text-zinc-400">Group by:</span>
                    <select x-model="groupBy" @change="fetchData()" class="px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary">
                        <option value="">None</option>
                        <template x-for="col in groupableColumns" :key="col.key">
                            <option :value="col.key" x-text="col.label"></option>
                        </template>
                    </select>
                </div>
            </template>
        </div>
        
        <!-- Table -->
        <div class="overflow-auto relative" x-ref="tableContainer" :class="{ 'max-h-[600px]': stickyHeader }">
            <table class="w-full border-collapse" role="grid">
                <thead x-ref="tableHead" class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <template x-if="selectable">
                            <th scope="col" class="sticky top-0 z-20 px-4 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700" :style="freezeStyle(0)">
                                <input 
                                    type="checkbox"
                                    x-model="selectAll"
                                    @change="toggleSelectAll"
                                    class="w-4 h-4 rounded border-zinc-300 text-primary focus:ring-primary"
                                    aria-label="Select all"
                                />
                            </th>
                        </template>
                        
                        <template x-for="(col, cIndex) in columns" :key="col.key">
                            <th 
                                scope="col"
                                class="sticky top-0 z-20 px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider text-xs border-b border-zinc-200 dark:border-zinc-700"
                                :class="{
                                    'cursor-pointer select-none hover:text-zinc-900 dark:hover:text-white': col.sortable,
                                    'text-center': col.align === 'center',
                                    'text-right': col.align === 'right',
                                }"
                                :style="freezeStyle(cIndex + (selectable ? 1 : 0))"
                                @click="col.sortable && sort(col.key)"
                                :aria-sort="sortBy === col.key ? (sortDirection === 'asc' ? 'ascending' : 'descending') : 'none'"
                            >
                                <div class="flex items-center gap-1" :class="{ 'justify-center': col.align === 'center', 'justify-end': col.align === 'right' }">
                                    <span x-text="col.label"></span>
                                    <template x-if="col.sortable && sortBy === col.key">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7'"/>
                                        </svg>
                                    </template>
                                    <template x-if="col.sortable && sortBy !== col.key">
                                        <svg class="w-4 h-4 text-zinc-300 dark:text-zinc-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/></svg>
                                    </template>
                                </div>
                                
                                <!-- Resize handle -->
                                <template x-if="resizableColumns">
                                    <div 
                                        class="absolute right-0 top-0 bottom-0 w-1 cursor-col-resize hover:bg-primary/50 transition-colors"
                                        @mousedown.prevent="startResizeColumn($event, cIndex)"
                                    ></div>
                                </template>
                            </th>
                        </template>
                    </tr>
                </thead>
                
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    <!-- Grouped rows -->
                    <template x-if="groupBy">
                        <template x-for="(group, gIndex) in groupedRows" :key="group.key">
                            <template x-for="(row, rIndex) in group.rows" :key="row.__id">
                                <tr></tr>
                            </template>
                        </template>
                    </template>
                    
                    <!-- Empty state -->
                    <template x-if="displayRows.length === 0">
                        <tr>
                            <td :colspan="columns.length + (selectable ? 1 : 0)" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-16 h-16 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <p class="text-zinc-500 dark:text-zinc-400" x-text="search ? 'No results found for &quot;' + search + '&quot;' : emptyMessage"></p>
                                </div>
                            </td>
                        </tr>
                    </template>
                    
                    <!-- Regular rows -->
                    <template x-for="(row, rIndex) in displayRows" :key="row.__id">
                        <tr 
                            class="transition-colors duration-100 hover:bg-zinc-50 dark:hover:bg-zinc-800/50"
                            :class="{ 'bg-primary/5 dark:bg-primary/10': selectedRowIds.includes(row.__id) }"
                            @click="selectable && toggleRowSelect(row.__id, $event)"
                            x-data="{ editing: false, editValues: {} }"
                        >
                            <template x-if="selectable">
                                <td class="px-4 py-3 border-b border-zinc-100 dark:border-zinc-800" :style="freezeStyle(0)">
                                    <input 
                                        type="checkbox"
                                        :checked="selectedRowIds.includes(row.__id)"
                                        @click.stop="toggleRowSelect(row.__id, $event)"
                                        class="w-4 h-4 rounded border-zinc-300 text-primary focus:ring-primary"
                                        :aria-label="'Select row ' + (rIndex + 1)"
                                    />
                                </td>
                            </template>
                            
                            <template x-for="(col, cIndex) in columns" :key="col.key">
                                <td 
                                    class="px-4 py-3 text-sm text-zinc-900 dark:text-white border-b border-zinc-100 dark:border-zinc-800"
                                    :class="{
                                        'text-center': col.align === 'center',
                                        'text-right tabular-nums': col.align === 'right',
                                        'font-medium': col.bold,
                                    }"
                                    :style="freezeStyle(cIndex + (selectable ? 1 : 0))"
                                >
                                    <template x-if="editable && col.editable && editing">
                                        <input 
                                            type="text"
                                            x-model="editValues[col.key]"
                                            @blur="saveInlineEdit(row, col, editValues[col.key])"
                                            @keydown.enter.prevent="$event.target.blur()"
                                            @keydown.escape.prevent="editing = false"
                                            class="w-full px-2 py-1 border border-primary rounded bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                                            x-ref="editInput"
                                        />
                                    </template>
                                    <template x-if="!editable || !editing">
                                        <div class="flex items-center gap-2" :class="{ 'justify-center': col.align === 'center', 'justify-end': col.align === 'right' }">
                                            <template x-if="col.render">
                                                <span x-html="col.render(row)"></span>
                                            </template>
                                            <template x-if="!col.render">
                                                <span x-text="resolveNestedValue(row, col.key)"></span>
                                            </template>
                                            <template x-if="editable && col.editable && !editing">
                                                <button @click.stop="startInlineEdit(row, col, $event)" class="p-1 opacity-0 group-hover:opacity-100 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded transition-all" title="Edit">
                                                    <svg class="w-3.5 h-3.5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                </td>
                            </template>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                Showing <span class="font-medium" x-text="((page - 1) * perPage) + 1"></span>
                to <span class="font-medium" x-text="Math.min(page * perPage, total)"></span>
                of <span class="font-medium" x-text="total"></span> results
            </div>
            
            <div class="flex items-center gap-1">
                <button @click="page = 1" :disabled="page === 1" class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" aria-label="First page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                </button>
                <button @click="page--" :disabled="page === 1" class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" aria-label="Previous page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                
                <template x-for="p in visiblePages" :key="p">
                    <button 
                        @click="page = p"
                        class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors"
                        :class="page === p ? 'bg-primary text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700'"
                        :aria-current="page === p ? 'page' : null"
                        x-text="p"
                    ></button>
                </template>
                
                <button @click="page++" :disabled="page >= totalPages" class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" aria-label="Next page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                <button @click="page = totalPages" :disabled="page >= totalPages" class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors" aria-label="Last page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiDataGridPro', (config) => ({
        columns: config.columns,
        rows: config.rows,
        total: config.total,
        perPage: config.perPage,
        page: config.page,
        sortBy: config.sortBy,
        sortDirection: config.sortDirection,
        groupBy: config.groupBy,
        selectable: config.selectable,
        editable: config.editable,
        resizableColumns: config.resizableColumns,
        freezeColumns: config.freezeColumns,
        stickyHeader: config.stickyHeader,
        serverSide: config.serverSide,
        
        search: '',
        selectedRowIds: [],
        columnWidths: {},
        loading: false,
        rowIdCounter: 0,
        
        get groupableColumns() {
            return this.columns.filter(c => c.groupable !== false);
        },
        
        get displayRows() {
            let rows = this.rows;
            
            if (this.search) {
                const q = this.search.toLowerCase();
                rows = rows.filter(row => this.columns.some(col => {
                    const val = this.resolveNestedValue(row, col.key);
                    return val != null && String(val).toLowerCase().includes(q);
                }));
            }
            
            // Apply sorting (client-side)
            if (this.sortBy && !this.serverSide) {
                rows = [...rows].sort((a, b) => {
                    const aVal = this.resolveNestedValue(a, this.sortBy);
                    const bVal = this.resolveNestedValue(b, this.sortBy);
                    if (aVal == null) return 1;
                    if (bVal == null) return -1;
                    if (typeof aVal === 'number') return this.sortDirection === 'asc' ? aVal - bVal : bVal - aVal;
                    return this.sortDirection === 'asc' 
                        ? String(aVal).localeCompare(String(bVal))
                        : String(bVal).localeCompare(String(aVal));
                });
            }
            
            return rows.map(row => ({
                ...row,
                __id: row.id || 'row-' + (++this.rowIdCounter)
            }));
        },
        
        get groupedRows() {
            if (!this.groupBy) return null;
            const groups = {};
            this.displayRows.forEach(row => {
                const key = this.resolveNestedValue(row, this.groupBy) || '(empty)';
                if (!groups[key]) groups[key] = { key, label: String(key), rows: [] };
                groups[key].rows.push(row);
            });
            return Object.values(groups);
        },
        
        get totalPages() {
            return Math.ceil(this.total / this.perPage);
        },
        
        get visiblePages() {
            const pages = [];
            const maxVisible = 5;
            let start = Math.max(1, this.page - Math.floor(maxVisible / 2));
            let end = Math.min(this.totalPages, start + maxVisible - 1);
            if (end - start + 1 < maxVisible) start = Math.max(1, end - maxVisible + 1);
            for (let i = start; i <= end; i++) pages.push(i);
            return pages;
        },
        
        get selectAll() {
            return this.displayRows.length > 0 && this.selectedRowIds.length === this.displayRows.length;
        },
        
        set selectAll(value) {
            this.selectedRowIds = value ? this.displayRows.map(r => r.__id) : [];
            this.$dispatch('datagrid:selection-change', this.selectedRowIds);
        },
        
        toggleSelectAll() {
            this.selectAll = !this.selectAll;
        },
        
        toggleRowSelect(rowId, event) {
            if (event.target.type === 'checkbox') return;
            const idx = this.selectedRowIds.indexOf(rowId);
            if (idx >= 0) this.selectedRowIds.splice(idx, 1);
            else this.selectedRowIds.push(rowId);
            this.$dispatch('datagrid:selection-change', this.selectedRowIds);
        },
        
        resolveNestedValue(obj, path) {
            return path.split('.').reduce((o, k) => (o != null ? o[k] : undefined), obj);
        },
        
        freezeStyle(colIndex) {
            if (colIndex < this.freezeColumns) {
                let left = 0;
                for (let i = 0; i < colIndex; i++) {
                    left += (this.selectable && i === 0 ? 48 : 160);
                }
                return `position: sticky; left: ${left}px; z-index: 15; background: inherit;`;
            }
            return '';
        },
        
        sort(key) {
            if (this.sortBy === key) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortBy = key;
                this.sortDirection = 'asc';
            }
            this.page = 1;
            this.fetchData();
        },
        
        searchTable() {
            this.page = 1;
            this.fetchData();
        },
        
        fetchData() {
            if (!this.serverSide) return;
            this.loading = true;
            this.$dispatch('datagrid:fetch', {
                page: this.page,
                perPage: this.perPage,
                sortBy: this.sortBy,
                sortDirection: this.sortDirection,
                search: this.search,
                groupBy: this.groupBy,
            });
        },
        
        // Inline editing
        startInlineEdit(row, col, event) {
            const tr = event.target.closest('tr');
            const alpine = Alpine.$data(tr);
            alpine.editing = true;
            alpine.editValues = { [col.key]: this.resolveNestedValue(row, col.key) };
            this.$nextTick(() => {
                tr.querySelector('[x-ref="editInput"]')?.focus();
            });
        },
        
        saveInlineEdit(row, col, value) {
            row[col.key] = value;
            this.$dispatch('datagrid:cell-updated', { row, column: col.key, value });
        },
        
        // Column resize
        startResizeColumn(event, colIndex) {
            const startX = event.clientX;
            const th = event.target.closest('th');
            const startWidth = th.offsetWidth;
            
            const onMove = (e) => {
                const diff = e.clientX - startX;
                th.style.width = Math.max(60, startWidth + diff) + 'px';
                th.style.minWidth = th.style.width;
            };
            
            const onUp = () => {
                document.removeEventListener('mousemove', onMove);
                document.removeEventListener('mouseup', onUp);
                document.body.style.cursor = '';
                document.body.style.userSelect = '';
            };
            
            document.addEventListener('mousemove', onMove);
            document.addEventListener('mouseup', onUp);
            document.body.style.cursor = 'col-resize';
            document.body.style.userSelect = 'none';
        },
        
        // Export
        exportData(format) {
            if (format === 'csv') {
                const headers = this.columns.map(c => c.label).join(',');
                const rows = this.displayRows.map(row => 
                    this.columns.map(col => {
                        const val = this.resolveNestedValue(row, col.key);
                        return val != null ? `"${String(val).replace(/"/g, '""')}"` : '';
                    }).join(',')
                ).join('\n');
                const csv = headers + '\n' + rows;
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'export.csv';
                a.click();
                URL.revokeObjectURL(url);
            }
        },
        
        importData(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                try {
                    const data = JSON.parse(e.target.result);
                    if (Array.isArray(data)) {
                        this.$dispatch('datagrid:imported', { data });
                    }
                } catch {
                    // CSV parse would go here
                }
            };
            reader.readAsText(file);
            event.target.value = '';
        },
        
        init() {
            this.rowIdCounter = Math.max(0, ...this.rows.map(r => {
                const id = r.id || '';
                const num = parseInt(String(id).split('-')[1]);
                return isNaN(num) ? 0 : num;
            }));
        },
    }));
});
</script>

<style>
.gsmui-datagrid-pro {
    @apply font-sans;
}

.gsmui-datagrid-pro table {
    border-collapse: collapse;
}

.gsmui-datagrid-pro th {
    @apply whitespace-nowrap;
    position: relative;
}

.gsmui-datagrid-pro td {
    @apply whitespace-nowrap;
}

.gsmui-datagrid-pro .group-header:hover {
    @apply bg-zinc-100 dark:bg-zinc-700/50;
}
</style>
