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
    'selected' => [],
    'density' => 'comfortable', // comfortable, compact, condensed
    'striped' => false,
    'bordered' => true,
    'hoverable' => true,
    'virtualized' => false,
    'selectable' => false,
    'serverSide' => false,
    'loading' => false,
    'emptyMessage' => 'No data available',
    'loadingMessage' => 'Loading...',
    'class' => '',
])

<?php
$densityClasses = match($density) {
    'compact' => 'px-3 py-2',
    'condensed' => 'px-2 py-1.5',
    default => 'px-4 py-3',
};

$headerDensityClasses = match($density) {
    'compact' => 'px-3 py-2',
    'condensed' => 'px-2 py-1.5',
    default => 'px-4 py-3',
};

$rowClasses = 'transition-colors duration-100';
$rowClasses .= $hoverable ? ' hover:bg-zinc-50 dark:hover:bg-zinc-800/50' : '';
$rowClasses .= $striped ? ' even:bg-zinc-50/50 dark:even:bg-zinc-800/50' : '';
?>

<div class="gsmui-datagrid {{ $class }}" x-data="gsmuiDatagrid({
    page: @js($page),
    perPage: @js($perPage),
    total: @js($total ?? count($rows)),
    sortBy: @js($sortBy),
    sortDirection: @js($sortDirection),
    selected: @js($selected),
    serverSide: @js($serverSide),
    virtualized: @js($virtualized),
    density: '@js($density)',
})" data-gsmui-datagrid>
    
    <!-- Toolbar -->
    <div class="flex flex-col sm:flex-row gap-4 mb-4 p-4 bg-white dark:bg-zinc-800 rounded-lg border border-zinc-200 dark:border-zinc-700" x-show="!loading">
        <div class="flex-1 min-w-0">
            <label for="datagrid-search" class="sr-only">Search</label>
            <div class="relative">
                <x-gsmui:icon name="magnifying-glass" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-zinc-400" />
                <input 
                    type="search" 
                    id="datagrid-search"
                    x-model.debounce.300ms="search"
                    @keydown.enter.prevent="searchTable()"
                    class="w-full pl-10 pr-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                    placeholder="Search..."
                    aria-label="Search table"
                />
            </div>
        </div>
        
        <div class="flex items-center gap-2">
            <label for="datagrid-per-page" class="text-sm text-zinc-600 dark:text-zinc-400">Show</label>
            <select 
                id="datagrid-per-page"
                x-model="perPage"
                @change="page = 1; fetchData()"
                class="px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
            >
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-sm text-zinc-600 dark:text-zinc-400">per page</span>
        </div>
    </div>
    
    <!-- Loading State -->
    <div x-show="loading" class="flex items-center justify-center py-12">
        <x-gsmui:spinner size="lg" />
        <span class="ml-3 text-zinc-600 dark:text-zinc-400">{{ $loadingMessage }}</span>
    </div>
    
    <!-- Table -->
    <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700" x-show="!loading">
        <table class="w-full" role="grid">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                <tr>
                    @if($selectable)
                        <th scope="col" class="{{ $headerDensityClasses }} text-left">
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    x-model="selectAll"
                                    @change="toggleSelectAll"
                                    class="w-4 h-4 rounded border-zinc-300 text-primary focus:ring-primary"
                                    aria-label="Select all rows"
                                />
                            </div>
                        </th>
                    @endif
                    
                    @foreach($columns as $column)
                        <th 
                            scope="col" 
                            class="{{ $headerDensityClasses }} text-left font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider text-xs
                                {{ $column['sortable'] ? 'cursor-pointer select-none hover:text-zinc-900 dark:hover:text-white' : '' }}
                                {{ $column['align'] === 'center' ? 'text-center' : '' }}
                                {{ $column['align'] === 'right' ? 'text-right' : '' }}
                                {{ $column['width'] ? 'w-' . str_replace('px', '', $column['width']) : '' }}
                            "
                            @if($column['sortable'])
                                @click="sort('{{ $column['key'] }}')"
                            @endif
                            style="{{ $column['width'] ? 'width: ' . $column['width'] . '; min-width: ' . $column['width'] . ';' : '' }}"
                            aria-sort="{{ $sortBy === $column['key'] ? ($sortDirection === 'asc' ? 'ascending' : 'descending') : 'none' }}"
                        >
                            <div class="flex items-center gap-1">
                                {{ $column['label'] }}
                                @if($column['sortable'] && $sortBy === $column['key'])
                                    <x-gsmui:icon :name="$sortDirection === 'asc' ? 'chevron-up' : 'chevron-down'" class="w-4 h-4" />
                                @elseif($column['sortable'])
                                    <x-gsmui:icon name="chevron-up-down" class="w-4 h-4 text-zinc-300 dark:text-zinc-600" />
                                @endif
                            </div>
                        </th>
                    @endforeach
                    
                    @if(isset($bulkActions))
                        <th scope="col" class="{{ $headerDensityClasses }} text-right">Actions</th>
                    @endif
                </tr>
            </thead>
            
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-800">
                @if(empty($rows) && !loading)
                    <tr>
                        <td colspan="{{ count($columns) + ($selectable ? 1 : 0) + (isset($bulkActions) ? 1 : 0) }}" class="px-4 py-12 text-center">
                            <x-gsmui:empty-state 
                                icon="table" 
                                title="No data" 
                                description="{{ $emptyMessage }}"
                                size="sm"
                            />
                        </td>
                    </tr>
                @else
                    @foreach($rows as $rowIndex => $row)
                        <tr 
                            class="{{ $rowClasses }} {{ $selected->contains($row->id ?? $rowIndex) ? 'bg-primary/5 dark:bg-primary/10' : '' }}"
                            @if($selectable)
                                @click="toggleRowSelect('{{ $row->id ?? $rowIndex }}', $event)"
                            @endif
                            x-data="{ rowId: '{{ $row->id ?? $rowIndex }}', rowData: @js($row) }"
                        >
                            @if($selectable)
                                <td class="{{ $densityClasses }} text-center">
                                    <input 
                                        type="checkbox" 
                                        x-model="selectedRowIds"
                                        :value="rowId"
                                        class="w-4 h-4 rounded border-zinc-300 text-primary focus:ring-primary"
                                        aria-label="Select row"
                                    />
                                </td>
                            @endif
                            
                            @foreach($columns as $column)
                                <td 
                                    class="{{ $densityClasses }} text-sm text-zinc-900 dark:text-white
                                        {{ $column['align'] === 'center' ? 'text-center' : '' }}
                                        {{ $column['align'] === 'right' ? 'text-right tabular-nums' : '' }}
                                        {{ $column['class'] ?? '' }}"
                                    style="{{ $column['width'] ? 'width: ' . $column['width'] . '; min-width: ' . $column['width'] . ';' : '' }}"
                                >
                                    @if($column['render'])
                                        {{ $column['render']($row) }}
                                    @else
                                        {{ $row[$column['key']] ?? '' }}
                                    @endif
                                </td>
                            @endforeach
                            
                            @if(isset($bulkActions))
                                <td class="{{ $densityClasses }} text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        @if($rowActions = $attributes->get('actions') ?? [])
                                            @foreach($rowActions as $action)
                                                <x-gsmui:button 
                                                    size="xs" 
                                                    variant="{{ $action['variant'] ?? 'ghost' }}" 
                                                    icon="{{ $action['icon'] ?? '' }}"
                                                    @click="{{ $action['handler'] ?? \"\$dispatch('datagrid:action', { action: '{$action['action']}', row: rowData })\" }}"
                                                >
                                                    {{ $action['label'] }}
                                                </x-gsmui:button>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div x-show="!loading && total > perPage" class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-zinc-600 dark:text-zinc-400">
            Showing <span class="font-medium">{{ (page - 1) * perPage + 1 }}</span> to <span class="font-medium">{{ min(page * perPage, total) }}</span> of <span class="font-medium">{{ total }}</span> results
        </div>
        
        <div class="flex items-center gap-1">
            <button 
                @click="page = 1" 
                :disabled="page === 1"
                class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                aria-label="First page"
            >
                <x-gsmui:icon name="chevron-double-left" class="w-4 h-4" />
            </button>
            
            <button 
                @click="page--" 
                :disabled="page === 1"
                class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                aria-label="Previous page"
            >
                <x-gsmui:icon name="chevron-left" class="w-4 h-4" />
            </button>
            
            <template x-for="p in getVisiblePages()" :key="p">
                <button 
                    @click="page = p"
                    class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                        {{ page === p ? 'bg-primary text-white' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700' }}"
                    :aria-current="page === p ? 'page' : null"
                    :aria-label="'Page ' + p"
                >
                    {{ p }}
                </button>
            </template>
            
            <button 
                @click="page++" 
                :disabled="page >= totalPages"
                class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                aria-label="Next page"
            >
                <x-gsmui:icon name="chevron-right" class="w-4 h-4" />
            </button>
            
            <button 
                @click="page = totalPages" 
                :disabled="page >= totalPages"
                class="p-2 rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                aria-label="Last page"
            >
                <x-gsmui:icon name="chevron-double-right" class="w-4 h-4" />
            </button>
        </div>
    </div>
</div>

<script>
function gsmuiDatagrid({ page, perPage, total, sortBy, sortDirection, selected, serverSide, virtualized, density }) {
    return {
        page,
        perPage,
        total,
        sortBy,
        sortDirection,
        selectedRowIds: selected || [],
        serverSide,
        virtualized,
        density,
        search: '',
        searchTimeout: null,
        loading: false,
        
        get totalPages() {
            return Math.ceil(this.total / this.perPage);
        },
        
        get selectAll() {
            return this.rows.length > 0 && this.selectedRowIds.length === this.rows.length;
        },
        
        set selectAll(value) {
            if (value) {
                this.selectedRowIds = this.rows.map(r => r.id ?? r);
            } else {
                this.selectedRowIds = [];
            }
            this.$dispatch('datagrid:selection-change', this.selectedRowIds);
        },
        
        toggleSelectAll() {
            this.selectAll = !this.selectAll;
        },
        
        toggleRowSelect(rowId, event) {
            if (event.target.type === 'checkbox') return;
            
            const idx = this.selectedRowIds.indexOf(rowId);
            if (idx >= 0) {
                this.selectedRowIds.splice(idx, 1);
            } else {
                this.selectedRowIds.push(rowId);
            }
            this.$dispatch('datagrid:selection-change', this.selectedRowIds);
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
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.page = 1;
                this.fetchData();
            }, 300);
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
            });
        },
        
        getVisiblePages() {
            const pages = [];
            const maxVisible = 5;
            let start = Math.max(1, this.page - Math.floor(maxVisible / 2));
            let end = Math.min(this.totalPages, start + maxVisible - 1);
            
            if (end - start + 1 < maxVisible) {
                start = Math.max(1, end - maxVisible + 1);
            }
            
            for (let i = start; i <= end; i++) {
                pages.push(i);
            }
            return pages;
        },
        
        init() {
            this.$watch('perPage', () => {
                this.page = 1;
                this.fetchData();
            });
            
            this.$watch('search', () => {
                this.searchTable();
            });
        }
    }
}
</script>

@push('gsmui-styles')
<style>
[data-gsmui-datagrid] table {
    border-collapse: collapse;
}

[data-gsmui-datagrid] th {
    position: sticky;
    top: 0;
    z-index: 10;
    background: inherit;
}

[data-gsmui-datagrid] tr.selected {
    @apply bg-primary/5 dark:bg-primary/10;
}

[data-gsmui-datagrid] .tabular-nums {
    font-variant-numeric: tabular-nums;
}

/* Virtualized scrolling */
[data-gsmui-datagrid].virtualized tbody {
    contain: strict;
}

/* Selection styles */
[data-gsmui-datagrid] input[type="checkbox"]:focus-visible {
    @apply outline-none ring-2 ring-primary ring-offset-2 ring-offset-white dark:ring-offset-zinc-800;
}
</style>
@endpush