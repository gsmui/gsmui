@props([
    'data' => [],
    'expandDepth' => 3,
    'searchable' => true,
    'copyable' => true,
    'showLineNumbers' => false,
    'maxStringLength' => 100,
    'dark' => false,
    'class' => '',
])

<?php
$id = 'json-viewer-' . uniqid();
?>

<div 
    class="gsmui-json-viewer {{ $class }}"
    x-data="gsmuiJsonViewer({
        data: @js($data),
        expandDepth: @js($expandDepth),
        searchable: @js($searchable),
        copyable: @js($copyable),
        showLineNumbers: @js($showLineNumbers),
        maxStringLength: @js($maxStringLength),
        dark: @js($dark),
    })"
    id="{{ $id }}"
    role="tree"
    aria-label="JSON viewer"
>
    <div class="json-viewer-container rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden" :class="{ 'dark-mode': dark }">
        
        <!-- Toolbar -->
        <div class="px-4 py-3 bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 flex items-center gap-3">
            <template x-if="searchable">
                <div class="relative flex-1 max-w-xs">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input 
                        type="search"
                        x-model="searchQuery"
                        @input="performSearch"
                        class="w-full pl-9 pr-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="Search..."
                        aria-label="Search JSON"
                    />
                </div>
            </template>
            
            <div class="flex items-center gap-1 ml-auto">
                <button @click="expandAll()" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors">Expand All</button>
                <button @click="collapseAll()" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors">Collapse All</button>
                
                <template x-if="copyable">
                    <button @click="copyJson()" class="px-3 py-1.5 text-xs border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors" title="Copy JSON">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                </template>
            </div>
        </div>
        
        <!-- Tree Content -->
        <div class="overflow-auto max-h-[600px] p-4 bg-white dark:bg-zinc-800" x-ref="viewer">
            <div class="font-mono text-sm leading-relaxed">
                <template x-for="(line, index) in renderedLines" :key="index">
                    <div class="json-line flex" :class="{ 'bg-primary/5 dark:bg-primary/10': line.isHighlighted }">
                        <template x-if="showLineNumbers">
                            <span class="json-line-number flex-shrink-0 w-8 text-right pr-3 text-zinc-400 dark:text-zinc-600 select-none" x-text="index + 1"></span>
                        </template>
                        <span class="json-line-content whitespace-pre" x-html="line.html"></span>
                    </div>
                </template>
            </div>
            
            <template x-if="filteredLines.length === 0 && searchQuery">
                <div class="text-center py-8 text-zinc-500 dark:text-zinc-400">
                    <p>No results found for "<span x-text="searchQuery"></span>"</p>
                </div>
            </template>
        </div>
        
        <!-- Status bar -->
        <div class="px-4 py-2 bg-zinc-50 dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400 flex items-center gap-4">
            <span x-text="'Size: ' + formatSize(jsonSize)"></span>
            <span x-text="'Keys: ' + totalKeys"></span>
            <span x-text="'Depth: ' + maxDepth"></span>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiJsonViewer', (config) => ({
        data: config.data,
        expandDepth: config.expandDepth,
        searchable: config.searchable,
        copyable: config.copyable,
        showLineNumbers: config.showLineNumbers,
        maxStringLength: config.maxStringLength,
        dark: config.dark,
        
        searchQuery: '',
        expandedNodes: new Set(),
        highlightedNodes: new Set(),
        jsonSize: 0,
        totalKeys: 0,
        maxDepth: 0,
        
        init() {
            this.analyzeData(this.data, 0);
            this.expandToDepth(this.data, 0);
        },
        
        analyzeData(obj, depth) {
            this.maxDepth = Math.max(this.maxDepth, depth);
            if (Array.isArray(obj)) {
                this.totalKeys += obj.length;
                obj.forEach(item => this.analyzeData(item, depth + 1));
            } else if (obj && typeof obj === 'object') {
                const keys = Object.keys(obj);
                this.totalKeys += keys.length;
                keys.forEach(k => this.analyzeData(obj[k], depth + 1));
            }
            this.jsonSize += this.estimateSize(obj);
        },
        
        estimateSize(obj) {
            const str = JSON.stringify(obj);
            return str ? str.length : 0;
        },
        
        expandToDepth(obj, currentDepth) {
            if (currentDepth >= this.expandDepth) return;
            const key = this.getNodeKey(obj);
            if (key) this.expandedNodes.add(key);
            
            if (Array.isArray(obj)) {
                obj.forEach(item => this.expandToDepth(item, currentDepth + 1));
            } else if (obj && typeof obj === 'object') {
                Object.values(obj).forEach(val => this.expandToDepth(val, currentDepth + 1));
            }
        },
        
        getNodeKey(obj, path = '') {
            if (typeof obj !== 'object' || obj === null) return null;
            return path || JSON.stringify(obj).slice(0, 50);
        },
        
        toggleExpand(obj) {
            const key = this.getNodeKey(obj);
            if (!key) return;
            if (this.expandedNodes.has(key)) {
                this.expandedNodes.delete(key);
            } else {
                this.expandedNodes.add(key);
            }
        },
        
        expandAll() {
            this.expandNodes(this.data, 0, 100);
        },
        
        collapseAll() {
            this.expandedNodes.clear();
        },
        
        expandNodes(obj, currentDepth, maxExpandDepth) {
            if (currentDepth >= maxExpandDepth) return;
            const key = this.getNodeKey(obj);
            if (key && typeof obj === 'object' && obj !== null) {
                this.expandedNodes.add(key);
                Object.values(obj).forEach(val => this.expandNodes(val, currentDepth + 1, maxExpandDepth));
            }
        },
        
        performSearch() {
            this.highlightedNodes.clear();
            if (!this.searchQuery) {
                this.expandToDepth(this.data, 0);
                return;
            }
            
            const q = this.searchQuery.toLowerCase();
            const searchObj = (obj, path) => {
                if (typeof obj === 'string' && obj.toLowerCase().includes(q)) {
                    const key = this.getNodeKey(obj, path);
                    if (key) this.highlightedNodes.add(key);
                    return true;
                }
                if (typeof obj === 'number' && String(obj).includes(q)) {
                    return true;
                }
                if (typeof obj === 'object' && obj !== null) {
                    let found = false;
                    Object.entries(obj).forEach(([k, v]) => {
                        if (k.toLowerCase().includes(q)) found = true;
                        if (searchObj(v, path + '.' + k)) found = true;
                    });
                    if (found) {
                        const key = this.getNodeKey(obj, path);
                        if (key) this.expandedNodes.add(key);
                    }
                    return found;
                }
                return false;
            };
            
            this.collapseAll();
            searchObj(this.data, '');
        },
        
        get renderedLines() {
            const lines = [];
            const q = this.searchQuery.toLowerCase();
            
            const render = (obj, indent, path) => {
                const indentation = '  '.repeat(indent);
                
                if (obj === null) {
                    lines.push({ html: indentation + '<span class="text-red-500 dark:text-red-400">null</span>', isHighlighted: false });
                    return;
                }
                
                if (typeof obj === 'boolean') {
                    lines.push({ html: indentation + '<span class="text-amber-600 dark:text-amber-400">' + obj + '</span>', isHighlighted: false });
                    return;
                }
                
                if (typeof obj === 'number') {
                    lines.push({ html: indentation + '<span class="text-emerald-600 dark:text-emerald-400">' + obj + '</span>', isHighlighted: false });
                    return;
                }
                
                if (typeof obj === 'string') {
                    let str = obj;
                    if (str.length > this.maxStringLength) {
                        str = str.slice(0, this.maxStringLength) + '...';
                    }
                    const escaped = str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    const highlighted = q && escaped.toLowerCase().includes(q) ? '<mark class="bg-yellow-200 dark:bg-yellow-800 px-0.5 rounded">' + escaped + '</mark>' : escaped;
                    lines.push({ html: indentation + '<span class="text-green-600 dark:text-green-400">"' + highlighted + '"</span>', isHighlighted: false });
                    return;
                }
                
                const isArray = Array.isArray(obj);
                const keys = Object.keys(obj);
                const isExpanded = this.expandedNodes.has(this.getNodeKey(obj, path));
                
                if (keys.length === 0) {
                    lines.push({ html: indentation + (isArray ? '[]' : '{}'), isHighlighted: false });
                    return;
                }
                
                const bracket = isArray ? '[' : '{';
                const closeBracket = isArray ? ']' : '}';
                const count = keys.length;
                
                if (isExpanded) {
                    lines.push({ html: indentation + bracket, isHighlighted: false });
                    
                    keys.forEach((key, i) => {
                        const isLast = i === keys.length - 1;
                        const childPath = path + '.' + key;
                        
                        if (isArray) {
                            render(obj[key], indent + 1, childPath);
                            if (!isLast) {
                                const lastLine = lines[lines.length - 1];
                                lastLine.html += '<span class="text-zinc-400">,</span>';
                            }
                        } else {
                            const keyStr = typeof key === 'string' ? key : String(key);
                            const isHighlighted = q && keyStr.toLowerCase().includes(q);
                            
                            lines.push({ 
                                html: '  '.repeat(indent + 1) + 
                                    '<span class="text-blue-600 dark:text-blue-400">"' + keyStr + '"</span>' + 
                                    '<span class="text-zinc-400">: </span>',
                                isHighlighted: isHighlighted
                            });
                            
                            const valueLineIndex = lines.length - 1;
                            const valueLines = [];
                            const tempRender = (v) => {
                                const vl = [];
                                const origRender = render;
                                render = (val, ind, p) => {
                                    // We need to inline simple values
                                    if (val === null || typeof val !== 'object') {
                                        const savedLen = lines.length;
                                        origRender(val, 0, p);
                                        const captured = lines.splice(savedLen);
                                        vl.push(...captured.map(l => l.html));
                                    } else {
                                        vl.push('...');
                                    }
                                };
                                render(v, 0, childPath);
                                render = origRender;
                            };
                            
                            // Track current line count to splice
                            const beforeCount = lines.length;
                            const isSimple = obj[key] === null || typeof obj[key] !== 'object';
                            
                            if (isSimple) {
                                render(obj[key], 0, childPath);
                                const captured = lines.splice(beforeCount);
                                lines[valueLineIndex].html += captured.map(l => l.html.trim()).join('');
                            } else {
                                render(obj[key], indent + 1, childPath);
                            }
                            
                            if (!isLast) {
                                lines[lines.length - 1].html += '<span class="text-zinc-400">,</span>';
                            }
                        }
                    });
                    
                    lines.push({ html: indentation + closeBracket, isHighlighted: false });
                } else {
                    const preview = isArray ? 'Array(' + count + ')' : 'Object(' + count + ')';
                    lines.push({ html: indentation + '<span class="cursor-pointer text-zinc-500 dark:text-zinc-400 hover:text-primary" @click.prevent="toggleExpand">' + bracket + ' ' + preview + ' ' + closeBracket + '</span>', isHighlighted: false });
                }
            };
            
            render(this.data, 0, 'root');
            return lines;
        },
        
        get filteredLines() {
            return this.renderedLines.filter(l => l.isHighlighted);
        },
        
        formatSize(bytes) {
            if (bytes < 1024) return bytes + ' B';
            if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
            return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
        },
        
        copyJson() {
            const text = JSON.stringify(this.data, null, 2);
            navigator.clipboard.writeText(text).catch(() => {
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            });
        },
    }));
});
</script>

<style>
.gsmui-json-viewer {
    @apply font-sans;
}

.gsmui-json-viewer .json-viewer-container {
    @apply transition-colors;
}

.gsmui-json-viewer .json-viewer-container.dark-mode {
    @apply bg-zinc-900 text-zinc-200;
}

.gsmui-json-viewer .json-line {
    @apply transition-colors duration-100;
}

.gsmui-json-viewer .json-line:hover {
    @apply bg-zinc-50 dark:bg-zinc-800/50;
}

.gsmui-json-viewer .json-line-content {
    @apply break-all;
}

.gsmui-json-viewer mark {
    @apply px-0.5 rounded;
}
</style>
