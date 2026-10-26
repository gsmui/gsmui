@props([
    'nodes' => [],
    'connections' => [],
    'nodeTypes' => [],
    'readonly' => false,
    'snapToGrid' => true,
    'gridSize' => 20,
    'class' => '',
])

<?php
$id = 'workflow-designer-' . uniqid();
$nodeTypes = $nodeTypes ?: [
    ['type' => 'start', 'label' => 'Start', 'icon' => 'play', 'color' => '#22c55e'],
    ['type' => 'end', 'label' => 'End', 'icon' => 'stop', 'color' => '#ef4444'],
    ['type' => 'action', 'label' => 'Action', 'icon' => 'cog', 'color' => '#3b82f6'],
    ['type' => 'condition', 'label' => 'Condition', 'icon' => 'question-mark-circle', 'color' => '#f59e0b'],
    ['type' => 'wait', 'label' => 'Wait', 'icon' => 'clock', 'color' => '#8b5cf6'],
    ['type' => 'notification', 'label' => 'Notification', 'icon' => 'bell', 'color' => '#ec4899'],
    ['type' => 'webhook', 'label' => 'Webhook', 'icon' => 'globe-alt', 'color' => '#06b6d4'],
    ['type' => 'subprocess', 'label' => 'Subprocess', 'icon' => 'rectangle-stack', 'color' => '#84cc16'],
];
?>

<div 
    class="gsmui-workflow-designer {{ $class }}"
    x-data="gsmuiWorkflowDesigner({
        nodes: @js($nodes),
        connections: @js($connections),
        nodeTypes: @js($nodeTypes),
        readonly: @js($readonly),
        snapToGrid: @js($snapToGrid),
        gridSize: @js($gridSize),
    })"
    id="{{ $id }}"
    role="application"
    aria-label="Workflow Designer"
>
    <div class="flex h-full bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-56 border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col overflow-hidden flex-shrink-0">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700">
                <h3 class="font-semibold text-zinc-900 dark:text-white text-sm">Node Palette</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Drag nodes to canvas</p>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-1.5">
                <template x-for="nt in nodeTypes" :key="nt.type">
                    <div 
                        class="node-palette-item flex items-center gap-2.5 px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-grab hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors select-none"
                        draggable="true"
                        @dragstart="dragNodePalette($event, nt)"
                        @dragend="dragEnd"
                    >
                        <div class="w-3 h-3 rounded-full flex-shrink-0" :style="{ backgroundColor: nt.color }"></div>
                        <span class="text-sm font-medium text-zinc-900 dark:text-white truncate" x-text="nt.label"></span>
                    </div>
                </template>
            </div>
            
            <div class="p-3 border-t border-zinc-200 dark:border-zinc-700 space-y-2">
                <button 
                    type="button"
                    @click="fitToScreen()"
                    class="w-full px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                >
                    Fit to Screen
                </button>
                <button 
                    type="button"
                    @click="exportWorkflow()"
                    class="w-full px-3 py-1.5 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 transition-colors"
                >
                    Export JSON
                </button>
            </div>
        </aside>
        
        <!-- Canvas -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Toolbar -->
            <div class="p-2 border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex items-center gap-2">
                <div class="flex items-center gap-1">
                    <button @click="zoomIn()" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Zoom In">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </button>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400 w-12 text-center" x-text="Math.round(zoom * 100) + '%'"></span>
                    <button @click="zoomOut()" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Zoom Out">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                    </button>
                </div>
                <div class="w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                <button @click="undo()" :disabled="historyIndex <= 0" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-40 transition-colors" title="Undo">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                </button>
                <button @click="redo()" :disabled="historyIndex >= history.length - 1" class="p-1.5 rounded hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-40 transition-colors" title="Redo">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6 6m6-6l-6-6"/></svg>
                </button>
                <div class="w-px h-5 bg-zinc-200 dark:bg-zinc-700"></div>
                <label class="flex items-center gap-1.5 text-sm text-zinc-600 dark:text-zinc-400 cursor-pointer">
                    <input type="checkbox" x-model="snapToGrid" class="w-4 h-4 text-primary rounded border-zinc-300">
                    Snap
                </label>
            </div>
            
            <!-- Canvas Area -->
            <div 
                class="flex-1 overflow-hidden relative bg-zinc-50 dark:bg-zinc-900/50"
                @dragover.prevent="handleCanvasDragOver($event)"
                @drop.prevent="handleCanvasDrop($event)"
                @mousedown="handleCanvasMouseDown($event)"
                @mousemove="handleCanvasMouseMove($event)"
                @mouseup="handleCanvasMouseUp"
                @mouseleave="handleCanvasMouseUp"
                x-ref="canvas"
            >
                <!-- Grid -->
                <svg class="absolute inset-0 pointer-events-none" width="100%" height="100%" x-show="showGrid">
                    <defs>
                        <pattern id="grid-{{ $id }}" :width="gridSize * zoom" :height="gridSize * zoom" patternUnits="userSpaceOnUse">
                            <path :d="'M ' + (gridSize * zoom) + ' 0 L 0 0 0 ' + (gridSize * zoom)" fill="none" stroke="currentColor" class="text-zinc-200 dark:text-zinc-800" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" :fill="'url(#grid-' + '{{ $id }}' + ')'"/>
                </svg>
                
                <!-- SVG Connections Layer -->
                <svg class="absolute inset-0 pointer-events-none" :style="{ transform: `scale(${zoom})`, transformOrigin: '0 0' }">
                    <template x-for="conn in connections" :key="conn.id">
                        <g class="connection-group" @click.stop="selectConnection(conn)">
                            <path 
                                :d="getConnectionPath(conn)"
                                fill="none"
                                :stroke="conn === selectedConnection ? '#3b82f6' : (conn.color || '#94a3b8')"
                                :stroke-width="conn === selectedConnection ? 3 : 2"
                                stroke-linecap="round"
                                class="transition-colors cursor-pointer"
                                :class="{ 'hover:stroke-primary/50': !readonly }"
                                pointer-events="visibleStroke"
                            />
                            <!-- Arrowhead -->
                            <template x-if="getConnectionEnd(conn)">
                                <circle :cx="getConnectionEnd(conn).x" :cy="getConnectionEnd(conn).y" r="4" :fill="conn.color || '#94a3b8'"/>
                            </template>
                            <!-- Delete button on hover -->
                            <template x-if="conn === hoveredConnection && !readonly">
                                <g class="connection-delete cursor-pointer" @click.stop="deleteConnection(conn)" pointer-events="all">
                                    <rect :x="getConnectionMidpoint(conn).x - 8" :y="getConnectionMidpoint(conn).y - 8" width="16" height="16" rx="8" fill="#ef4444" opacity="0.9"/>
                                    <text :x="getConnectionMidpoint(conn).x" :y="getConnectionMidpoint(conn).y + 4" text-anchor="middle" fill="white" font-size="12" font-weight="bold">×</text>
                                </g>
                            </template>
                        </g>
                    </template>
                    
                    <!-- Temporary connection while dragging -->
                    <template x-if="connecting.from">
                        <path :d="getTempConnectionPath()" fill="none" stroke="#3b82f6" stroke-width="2" stroke-dasharray="5,5" stroke-linecap="round"/>
                    </template>
                </svg>
                
                <!-- Nodes Layer -->
                <div class="absolute inset-0" :style="{ transform: `scale(${zoom})`, transformOrigin: '0 0' }">
                    <template x-for="node in nodes" :key="node.id">
                        <div 
                            class="workflow-node absolute group"
                            :class="{
                                'node-selected': selectedNode?.id === node.id,
                                'node-dragging': draggingNode?.id === node.id,
                                'cursor-grab': !readonly && selectedNode?.id !== node.id,
                                'cursor-grabbing': draggingNode?.id === node.id
                            }"
                            :style="{ left: node.x + 'px', top: node.y + 'px', width: node.width + 'px' }"
                            @mousedown.prevent="selectNode(node, $event)"
                            @dblclick="editNode(node)"
                            @mouseenter="hoveredNode = node"
                            @mouseleave="hoveredNode = null"
                        >
                            <!-- Connection ports -->
                            <template x-if="!readonly">
                                <div class="absolute -left-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full opacity-0 group-hover:opacity-100 cursor-crosshair transition-opacity z-10"
                                     @mousedown.stop @mouseup.stop @click.stop="startConnection(node, 'input')" title="Connect input"></div>
                            </template>
                            
                            <!-- Node body -->
                            <div 
                                class="rounded-lg border-2 overflow-hidden shadow-sm transition-shadow"
                                :class="{
                                    'shadow-lg ring-2 ring-primary': selectedNode?.id === node.id,
                                    'hover:shadow-md': !readonly
                                }"
                                :style="{ borderColor: node.color || getNodeTypeColor(node.type), backgroundColor: 'white' }"
                            >
                                <div class="flex items-center gap-2 px-3 py-2" :style="{ backgroundColor: (node.color || getNodeTypeColor(node.type)) + '15' }">
                                    <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" :style="{ backgroundColor: node.color || getNodeTypeColor(node.type) }"></div>
                                    <input 
                                        x-model="node.label"
                                        @click.stop
                                        @blur="updateNode(node)"
                                        @keydown.enter.prevent="$event.target.blur()"
                                        class="flex-1 text-sm font-semibold bg-transparent border-none focus:outline-none focus:ring-1 focus:ring-primary rounded px-1 text-zinc-900 dark:text-white"
                                        :readonly="readonly"
                                        placeholder="Node name"
                                    />
                                    <template x-if="!readonly">
                                        <button @click.stop="deleteNode(node)" class="p-0.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Output connection port -->
                            <template x-if="!readonly">
                                <div class="absolute -right-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-primary rounded-full opacity-0 group-hover:opacity-100 cursor-crosshair transition-opacity z-10"
                                     @mousedown.stop @mouseup.stop @click.stop="startConnection(node, 'output')" title="Connect output"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        
        <!-- Properties Panel -->
        <aside class="w-72 border-l border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex flex-col overflow-hidden flex-shrink-0" x-show="selectedNode || selectedConnection">
            <div class="p-3 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                <h3 class="font-semibold text-zinc-900 dark:text-white text-sm" x-text="selectedNode ? 'Node Properties' : 'Connection Properties'"></h3>
                <button @click="selectedNode = null; selectedConnection = null" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-3 space-y-4">
                <template x-if="selectedNode">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Label</label>
                            <input type="text" x-model="selectedNode.label" @input="updateNode(selectedNode)" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Type</label>
                            <select x-model="selectedNode.type" @change="changeNodeType(selectedNode, $event.target.value)" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary">
                                <template x-for="nt in nodeTypes" :key="nt.type">
                                    <option :value="nt.type" x-text="nt.label"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Color</label>
                            <input type="color" x-model="selectedNode.color" @input="updateNode(selectedNode)" class="w-full h-9 rounded border border-zinc-300 dark:border-zinc-600 cursor-pointer" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Description</label>
                            <textarea x-model="selectedNode.description" @input="updateNode(selectedNode)" rows="3" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Configuration (JSON)</label>
                            <textarea x-model="selectedNode.config" @input="updateNode(selectedNode)" rows="6" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary font-mono"></textarea>
                        </div>
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <button type="button" @click="deleteNode(selectedNode)" class="w-full px-3 py-2 text-sm text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">Delete Node</button>
                        </div>
                    </div>
                </template>
                <template x-if="selectedConnection">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Label</label>
                            <input type="text" x-model="selectedConnection.label" @input="updateConnection(selectedConnection)" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Color</label>
                            <input type="color" x-model="selectedConnection.color" @input="updateConnection(selectedConnection)" class="w-full h-9 rounded border border-zinc-300 dark:border-zinc-600 cursor-pointer" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Condition (optional)</label>
                            <textarea x-model="selectedConnection.condition" @input="updateConnection(selectedConnection)" rows="3" class="w-full px-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-700 focus:outline-none focus:ring-1 focus:ring-primary font-mono" placeholder="e.g., status === 'approved'"></textarea>
                        </div>
                        <div class="pt-2 border-t border-zinc-200 dark:border-zinc-700">
                            <button type="button" @click="deleteConnection(selectedConnection)" class="w-full px-3 py-2 text-sm text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">Delete Connection</button>
                        </div>
                    </div>
                </template>
            </div>
        </aside>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiWorkflowDesigner', (config) => ({
        nodes: config.nodes || [],
        connections: config.connections || [],
        nodeTypes: config.nodeTypes,
        readonly: config.readonly,
        snapToGrid: config.snapToGrid,
        gridSize: config.gridSize,
        
        zoom: 1,
        showGrid: true,
        selectedNode: null,
        selectedConnection: null,
        hoveredNode: null,
        hoveredConnection: null,
        draggingNode: null,
        dragOffset: { x: 0, y: 0 },
        connecting: { from: null, to: null },
        canvasOffset: { x: 0, y: 0 },
        nodeIdCounter: 0,
        connIdCounter: 0,
        
        get nodeTypesMap() {
            const map = {};
            this.nodeTypes.forEach(nt => { map[nt.type] = nt; });
            return map;
        },
        
        init() {
            this.nodeIdCounter = Math.max(0, ...this.nodes.map(n => parseInt(n.id?.split('-')[1] || 0)));
            this.connIdCounter = Math.max(0, ...this.connections.map(c => parseInt(c.id?.split('-')[1] || 0)));
        },
        
        getNodeTypeColor(type) {
            return this.nodeTypesMap[type]?.color || '#3b82f6';
        },
        
        createNode(type, x, y) {
            const nt = this.nodeTypesMap[type] || this.nodeTypes[0];
            return {
                id: 'node-' + (++this.nodeIdCounter),
                type: type,
                label: nt.label,
                color: nt.color,
                description: '',
                config: '{}',
                x: x,
                y: y,
                width: 180,
            };
        },
        
        createConnection(from, to) {
            return {
                id: 'conn-' + (++this.connIdCounter),
                from: from,
                to: to,
                label: '',
                color: '#94a3b8',
                condition: '',
            };
        },
        
        addNode(node) {
            this.nodes.push(node);
            this.saveHistory();
        },
        
        addConnection(conn) {
            this.connections.push(conn);
            this.saveHistory();
        },
        
        selectNode(node, event) {
            if (this.readonly) return;
            this.selectedNode = node;
            this.selectedConnection = null;
            this.draggingNode = node;
            this.dragOffset = { x: event.clientX - node.x * this.zoom, y: event.clientY - node.y * this.zoom };
            event.preventDefault();
        },
        
        selectConnection(conn) {
            this.selectedConnection = conn;
            this.selectedNode = null;
        },
        
        editNode(node) {
            this.selectedNode = node;
        },
        
        updateNode(node) {
            // reactive
        },
        
        changeNodeType(node, newType) {
            node.type = newType;
            const nt = this.nodeTypesMap[newType];
            if (nt) {
                node.color = nt.color;
                node.label = nt.label;
            }
        },
        
        deleteNode(node) {
            this.nodes = this.nodes.filter(n => n.id !== node.id);
            this.connections = this.connections.filter(c => c.from !== node.id && c.to !== node.id);
            if (this.selectedNode === node) this.selectedNode = null;
            this.saveHistory();
        },
        
        updateConnection(conn) {
            // reactive
        },
        
        deleteConnection(conn) {
            this.connections = this.connections.filter(c => c.id !== conn.id);
            if (this.selectedConnection === conn) this.selectedConnection = null;
            this.saveHistory();
        },
        
        startConnection(node, port) {
            if (this.readonly) return;
            this.connecting = { from: node.id, port: port, mouseX: 0, mouseY: 0 };
        },
        
        handleCanvasMouseDown(event) {
            if (event.target !== this.$refs.canvas && !event.target.closest('.workflow-node') && !event.target.closest('.connection-group')) {
                this.selectedNode = null;
                this.selectedConnection = null;
            }
            
            if (this.connecting.from && !event.target.closest('.workflow-node')) {
                this.connecting = { from: null };
            }
        },
        
        handleCanvasMouseMove(event) {
            if (this.draggingNode) {
                const rawX = (event.clientX - this.dragOffset.x) / this.zoom;
                const rawY = (event.clientY - this.dragOffset.y) / this.zoom;
                this.draggingNode.x = this.snapToGrid ? Math.round(rawX / this.gridSize) * this.gridSize : rawX;
                this.draggingNode.y = this.snapToGrid ? Math.round(rawY / this.gridSize) * this.gridSize : rawY;
            }
            
            if (this.connecting.from) {
                const rect = this.$refs.canvas.getBoundingClientRect();
                this.connecting.mouseX = (event.clientX - rect.left) / this.zoom;
                this.connecting.mouseY = (event.clientY - rect.top) / this.zoom;
            }
        },
        
        handleCanvasMouseUp() {
            if (this.draggingNode) {
                this.saveHistory();
                this.draggingNode = null;
            }
        },
        
        handleCanvasDragOver(event) {
            event.dataTransfer.dropEffect = 'copy';
        },
        
        handleCanvasDrop(event) {
            const data = event.dataTransfer.getData('application/json');
            if (!data) return;
            
            try {
                const parsed = JSON.parse(data);
                if (parsed.type === 'new_node' && parsed.nodeType) {
                    const rect = this.$refs.canvas.getBoundingClientRect();
                    let x = (event.clientX - rect.left) / this.zoom;
                    let y = (event.clientY - rect.top) / this.zoom;
                    if (this.snapToGrid) {
                        x = Math.round(x / this.gridSize) * this.gridSize;
                        y = Math.round(y / this.gridSize) * this.gridSize;
                    }
                    const node = this.createNode(parsed.nodeType, x, y);
                    this.addNode(node);
                }
            } catch(e) {}
        },
        
        dragNodePalette(event, nt) {
            event.dataTransfer.setData('application/json', JSON.stringify({ type: 'new_node', nodeType: nt.type }));
            event.dataTransfer.effectAllowed = 'copy';
        },
        
        dragEnd() {},
        
        getNodePosition(nodeId) {
            const node = this.nodes.find(n => n.id === nodeId);
            if (!node) return { x: 0, y: 0 };
            return { x: node.x + node.width / 2, y: node.y + 30 };
        },
        
        getConnectionPath(conn) {
            const from = this.getNodePosition(conn.from);
            const to = this.getNodePosition(conn.to);
            const dx = Math.abs(to.x - from.x);
            const dy = Math.abs(to.y - from.y);
            const cx1 = from.x + Math.max(dx * 0.5, 50);
            const cy1 = from.y;
            const cx2 = to.x - Math.max(dx * 0.5, 50);
            const cy2 = to.y;
            return `M ${from.x} ${from.y} C ${cx1} ${cy1}, ${cx2} ${cy2}, ${to.x} ${to.y}`;
        },
        
        getTempConnectionPath() {
            const from = this.getNodePosition(this.connecting.from);
            return `M ${from.x} ${from.y} C ${from.x + 50} ${from.y}, ${this.connecting.mouseX - 50} ${this.connecting.mouseY}, ${this.connecting.mouseX} ${this.connecting.mouseY}`;
        },
        
        getConnectionEnd(conn) {
            const to = this.getNodePosition(conn.to);
            return to;
        },
        
        getConnectionMidpoint(conn) {
            const from = this.getNodePosition(conn.from);
            const to = this.getNodePosition(conn.to);
            return { x: (from.x + to.x) / 2, y: (from.y + to.y) / 2 };
        },
        
        zoomIn() {
            this.zoom = Math.min(2, this.zoom + 0.1);
        },
        
        zoomOut() {
            this.zoom = Math.max(0.3, this.zoom - 0.1);
        },
        
        fitToScreen() {
            if (this.nodes.length === 0) { this.zoom = 1; return; }
            const rect = this.$refs.canvas.getBoundingClientRect();
            const maxX = Math.max(...this.nodes.map(n => n.x + n.width));
            const maxY = Math.max(...this.nodes.map(n => n.y + 60));
            const scaleX = rect.width / (maxX + 100);
            const scaleY = rect.height / (maxY + 100);
            this.zoom = Math.min(1, Math.min(scaleX, scaleY));
        },
        
        getWorkflow() {
            return {
                nodes: this.nodes.map(n => ({
                    id: n.id, type: n.type, label: n.label, color: n.color,
                    description: n.description, config: n.config,
                    x: n.x, y: n.y, width: n.width
                })),
                connections: this.connections.map(c => ({
                    id: c.id, from: c.from, to: c.to,
                    label: c.label, color: c.color, condition: c.condition
                }))
            };
        },
        
        exportWorkflow() {
            const data = this.getWorkflow();
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'workflow.json';
            a.click();
            URL.revokeObjectURL(url);
        },
        
        // History
        history: [],
        historyIndex: -1,
        
        saveHistory() {
            const snapshot = JSON.stringify(this.getWorkflow());
            this.history = this.history.slice(0, this.historyIndex + 1);
            this.history.push(snapshot);
            this.historyIndex = this.history.length - 1;
        },
        
        undo() {
            if (this.historyIndex <= 0) return;
            this.historyIndex--;
            this.loadFromHistory();
        },
        
        redo() {
            if (this.historyIndex >= this.history.length - 1) return;
            this.historyIndex++;
            this.loadFromHistory();
        },
        
        loadFromHistory() {
            const data = JSON.parse(this.history[this.historyIndex]);
            this.nodes = data.nodes;
            this.connections = data.connections;
        },
    }));
});
</script>

<style>
.gsmui-workflow-designer {
    @apply h-full font-sans;
}

.gsmui-workflow-designer .node-palette-item {
    @apply select-none;
}

.gsmui-workflow-designer .workflow-node {
    @apply absolute select-none;
    z-index: 5;
    min-width: 150px;
}

.gsmui-workflow-designer .workflow-node.node-dragging {
    @apply opacity-90;
    z-index: 50;
}

.gsmui-workflow-designer .workflow-node .connection-port {
    @apply transition-opacity;
}

.gsmui-workflow-designer .connection-group {
    @apply transition-colors;
}
</style>
