@props([
    'initialElements' => [],
    'readonly' => false,
    'height' => '600px',
    'class' => '',
])

<?php
$id = 'whiteboard-' . uniqid();
?>

<div 
    class="gsmui-whiteboard {{ $class }}"
    x-data="gsmuiWhiteboard({
        elements: @js($initialElements),
        readonly: @js($readonly),
    })"
    id="{{ $id }}"
    role="application"
    aria-label="Whiteboard"
    style="height: {{ $height }};"
>
    <div class="flex h-full bg-zinc-50 dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        
        <!-- Toolbar -->
        <div class="flex flex-col border-r border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 flex-shrink-0" x-show="!readonly">
            <div class="p-2 space-y-1">
                <button @click="setTool('select')" :class="{ 'bg-primary/10 text-primary': tool === 'select' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Select">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </button>
                <button @click="setTool('pen')" :class="{ 'bg-primary/10 text-primary': tool === 'pen' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Pen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </button>
                <button @click="setTool('rect')" :class="{ 'bg-primary/10 text-primary': tool === 'rect' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Rectangle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
                </button>
                <button @click="setTool('circle')" :class="{ 'bg-primary/10 text-primary': tool === 'circle' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Circle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/></svg>
                </button>
                <button @click="setTool('arrow')" :class="{ 'bg-primary/10 text-primary': tool === 'arrow' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Arrow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
                <button @click="setTool('text')" :class="{ 'bg-primary/10 text-primary': tool === 'text' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Text">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7-6v12M4 18h16"/></svg>
                </button>
                <button @click="setTool('note')" :class="{ 'bg-primary/10 text-primary': tool === 'note' }" class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors" title="Sticky Note">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </button>
            </div>
            
            <div class="border-t border-zinc-200 dark:border-zinc-700 p-2">
                <div class="space-y-2">
                    <label class="text-xs text-zinc-500 dark:text-zinc-400 block">Color</label>
                    <div class="grid grid-cols-4 gap-1">
                        <template x-for="c in colors" :key="c">
                            <button @click="strokeColor = c" class="w-6 h-6 rounded-full border-2" :class="{ 'border-primary': strokeColor === c }" :style="{ backgroundColor: c }"></button>
                        </template>
                    </div>
                </div>
                <div class="mt-2">
                    <label class="text-xs text-zinc-500 dark:text-zinc-400 block mb-1">Size</label>
                    <input type="range" x-model="strokeWidth" min="1" max="20" class="w-full" />
                </div>
            </div>
        </div>
        
        <!-- Canvas -->
        <div class="flex-1 relative overflow-hidden bg-white dark:bg-zinc-800" 
             @mousedown="handleMouseDown($event)"
             @mousemove="handleMouseMove($event)"
             @mouseup="handleMouseUp"
             @mouseleave="handleMouseUp"
             x-ref="canvas">
            
            <!-- Drawing SVG layer -->
            <svg class="absolute inset-0 pointer-events-none" width="100%" height="100%">
                <template x-for="el in elements" :key="el.id">
                    <template x-if="el.type === 'drawing'">
                        <path :d="el.path" fill="none" :stroke="el.color" :stroke-width="el.strokeWidth" stroke-linecap="round" stroke-linejoin="round"/>
                    </template>
                    <template x-if="el.type === 'rect'">
                        <rect :x="el.x" :y="el.y" :width="el.width" :height="el.height" :fill="el.fill || 'transparent'" :stroke="el.color" :stroke-width="el.strokeWidth || 2"/>
                    </template>
                    <template x-if="el.type === 'circle'">
                        <ellipse :cx="el.x + el.width/2" :cy="el.y + el.height/2" :rx="el.width/2" :ry="el.height/2" :fill="el.fill || 'transparent'" :stroke="el.color" :stroke-width="el.strokeWidth || 2"/>
                    </template>
                    <template x-if="el.type === 'arrow'">
                        <g>
                            <line :x1="el.x" :y1="el.y" :x2="el.x2" :y2="el.y2" :stroke="el.color" :stroke-width="el.strokeWidth || 2" stroke-linecap="round"/>
                            <polygon :points="arrowHead(el)" :fill="el.color"/>
                        </g>
                    </template>
                </template>
            </svg>
            
            <!-- Text/Note elements (HTML overlay) -->
            <template x-for="el in elements" :key="el.id">
                <template x-if="el.type === 'text'">
                    <div 
                        class="absolute cursor-text"
                        :style="{ left: el.x + 'px', top: el.y + 'px', color: el.color, fontSize: (el.fontSize || 16) + 'px', minWidth: '50px', minHeight: '20px' }"
                        @dblclick="editTextElement(el)"
                        x-text="el.text"
                    ></div>
                </template>
                <template x-if="el.type === 'note'">
                    <div 
                        class="absolute rounded shadow-md p-3 cursor-pointer transition-shadow hover:shadow-lg"
                        :style="{ 
                            left: el.x + 'px', top: el.y + 'px', 
                            width: (el.width || 200) + 'px', 
                            backgroundColor: el.fill || '#fef3c7',
                            borderLeft: '4px solid ' + (el.color || '#f59e0b'),
                            transform: 'rotate(' + (el.rotation || -2) + 'deg)'
                        }"
                        @dblclick="editTextElement(el)"
                        @mousedown="startDrag($event, el)"
                    >
                        <p class="text-sm text-zinc-800" x-text="el.text || 'Double-click to edit'"></p>
                    </div>
                </template>
            </template>
            
            <!-- Connection lines -->
            <svg class="absolute inset-0 pointer-events-none">
                <template x-for="el in elements" :key="el.id">
                    <template x-if="el.type === 'connection'">
                        <path :d="el.path" fill="none" :stroke="el.color || '#94a3b8'" :stroke-width="el.strokeWidth || 2" stroke-dasharray="5,5"/>
                    </template>
                </template>
            </svg>
            
            <!-- Selection indicator -->
            <template x-if="selection">
                <div class="absolute border-2 border-primary/50 bg-primary/5 pointer-events-none rounded" 
                     :style="{ left: selection.x + 'px', top: selection.y + 'px', width: selection.width + 'px', height: selection.height + 'px' }">
                </div>
            </template>
            
            <!-- Active drawing preview -->
            <template x-if="drawing">
                <svg class="absolute inset-0 pointer-events-none">
                    <template x-if="currentTool === 'rect'">
                        <rect :x="Math.min(drawing.x, drawing.x2)" :y="Math.min(drawing.y, drawing.y2)" 
                              :width="Math.abs(drawing.x2 - drawing.x)" :height="Math.abs(drawing.y2 - drawing.y)"
                              fill="transparent" :stroke="strokeColor" :stroke-width="strokeWidth" stroke-dasharray="4,4"/>
                    </template>
                    <template x-if="currentTool === 'circle'">
                        <ellipse :cx="(drawing.x + drawing.x2)/2" :cy="(drawing.y + drawing.y2)/2"
                                 :rx="Math.abs(drawing.x2 - drawing.x)/2" :ry="Math.abs(drawing.y2 - drawing.y)/2"
                                 fill="transparent" :stroke="strokeColor" :stroke-width="strokeWidth" stroke-dasharray="4,4"/>
                    </template>
                    <template x-if="currentTool === 'arrow'">
                        <line :x1="drawing.x" :y1="drawing.y" :x2="drawing.x2" :y2="drawing.y2" :stroke="strokeColor" :stroke-width="strokeWidth" stroke-dasharray="4,4"/>
                    </template>
                </svg>
            </template>
            
            <!-- Empty state -->
            <template x-if="elements.length === 0">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="text-center text-zinc-400 dark:text-zinc-600">
                        <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm">Select a tool from the sidebar to start drawing</p>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('gsmuiWhiteboard', (config) => ({
        elements: config.elements || [],
        readonly: config.readonly,
        
        tool: 'select',
        strokeColor: '#3b82f6',
        strokeWidth: 2,
        colors: ['#3b82f6', '#ef4444', '#22c55e', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#6366f1', '#84cc16', '#f97316'],
        drawing: null,
        currentTool: 'select',
        selection: null,
        dragTarget: null,
        dragOffset: { x: 0, y: 0 },
        elemIdCounter: 0,
        
        init() {
            this.elemIdCounter = Math.max(0, ...this.elements.map(e => {
                const num = parseInt(String(e.id || '').split('-')[1]);
                return isNaN(num) ? 0 : num;
            }));
        },
        
        setTool(t) {
            this.tool = t;
            this.currentTool = t;
        },
        
        handleMouseDown(event) {
            if (this.readonly) return;
            const rect = this.$refs.canvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            
            if (this.tool === 'select') {
                // Check for element click
                const clickedEl = this.findElementAt(x, y);
                if (clickedEl) {
                    this.dragTarget = clickedEl;
                    this.dragOffset = { x: x - clickedEl.x, y: y - clickedEl.y };
                } else {
                    this.selection = { x, y, width: 0, height: 0 };
                }
                return;
            }
            
            if (this.tool === 'pen') {
                const path = `M ${x} ${y}`;
                this.drawing = { type: 'drawing', path, points: [{ x, y }] };
                this.currentTool = 'pen';
                return;
            }
            
            this.drawing = { x, y, x2: x, y2: y };
            this.currentTool = this.tool;
        },
        
        handleMouseMove(event) {
            if (!this.drawing && !this.dragTarget && !this.selection) return;
            const rect = this.$refs.canvas.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            
            if (this.dragTarget) {
                this.dragTarget.x = x - this.dragOffset.x;
                this.dragTarget.y = y - this.dragOffset.y;
                return;
            }
            
            if (this.selection && !this.drawing) {
                this.selection.width = x - this.selection.x;
                this.selection.height = y - this.selection.y;
                return;
            }
            
            if (this.drawing) {
                this.drawing.x2 = x;
                this.drawing.y2 = y;
                
                if (this.currentTool === 'pen') {
                    this.drawing.path += ` L ${x} ${y}`;
                    this.drawing.points.push({ x, y });
                }
            }
        },
        
        handleMouseUp() {
            if (this.readonly) return;
            
            if (this.dragTarget) {
                this.dragTarget = null;
                return;
            }
            
            if (this.selection) {
                this.selection = null;
                return;
            }
            
            if (!this.drawing) return;
            
            if (this.currentTool === 'pen' && this.drawing.points.length > 1) {
                this.addElement({
                    type: 'drawing',
                    path: this.drawing.path,
                    color: this.strokeColor,
                    strokeWidth: this.strokeWidth,
                });
            } else if (this.currentTool === 'rect') {
                const x = Math.min(this.drawing.x, this.drawing.x2);
                const y = Math.min(this.drawing.y, this.drawing.y2);
                const w = Math.abs(this.drawing.x2 - this.drawing.x);
                const h = Math.abs(this.drawing.y2 - this.drawing.y);
                if (w > 3 && h > 3) {
                    this.addElement({ type: 'rect', x, y, width: w, height: h, color: this.strokeColor, strokeWidth: this.strokeWidth, fill: this.strokeColor + '15' });
                }
            } else if (this.currentTool === 'circle') {
                const x = Math.min(this.drawing.x, this.drawing.x2);
                const y = Math.min(this.drawing.y, this.drawing.y2);
                const w = Math.abs(this.drawing.x2 - this.drawing.x);
                const h = Math.abs(this.drawing.y2 - this.drawing.y);
                if (w > 3 && h > 3) {
                    this.addElement({ type: 'circle', x, y, width: w, height: h, color: this.strokeColor, strokeWidth: this.strokeWidth, fill: this.strokeColor + '15' });
                }
            } else if (this.currentTool === 'arrow') {
                const dx = this.drawing.x2 - this.drawing.x;
                const dy = this.drawing.y2 - this.drawing.y;
                if (Math.sqrt(dx*dx + dy*dy) > 10) {
                    this.addElement({ type: 'arrow', x: this.drawing.x, y: this.drawing.y, x2: this.drawing.x2, y2: this.drawing.y2, color: this.strokeColor, strokeWidth: this.strokeWidth });
                }
            } else if (['text', 'note'].includes(this.currentTool)) {
                const text = prompt('Enter text:');
                if (text) {
                    this.addElement({
                        type: this.currentTool,
                        x: this.drawing.x,
                        y: this.drawing.y,
                        width: this.currentTool === 'note' ? 200 : undefined,
                        text: text,
                        color: this.strokeColor,
                        fill: this.currentTool === 'note' ? '#fef3c7' : undefined,
                        fontSize: 16,
                        rotation: this.currentTool === 'note' ? (Math.random() * 4 - 2) : 0,
                    });
                }
            }
            
            this.drawing = null;
            this.currentTool = this.tool;
        },
        
        addElement(el) {
            el.id = 'elem-' + (++this.elemIdCounter);
            this.elements.push(el);
            this.$dispatch('whiteboard:element-added', { element: el });
        },
        
        findElementAt(x, y) {
            // Check in reverse order (top-most first)
            for (let i = this.elements.length - 1; i >= 0; i--) {
                const el = this.elements[i];
                if (el.type === 'text' || el.type === 'note') {
                    if (x >= el.x && x <= (el.x + (el.width || 200)) && y >= el.y && y <= (el.y + 40)) {
                        return el;
                    }
                }
                if (el.type === 'rect' || el.type === 'circle') {
                    if (x >= el.x && x <= (el.x + el.width) && y >= el.y && y <= (el.y + el.height)) {
                        return el;
                    }
                }
            }
            return null;
        },
        
        arrowHead(el) {
            const angle = Math.atan2(el.y2 - el.y, el.x2 - el.x);
            const size = 10;
            const x = el.x2 - size * 0.3 * Math.cos(angle);
            const y = el.y2 - size * 0.3 * Math.sin(angle);
            const p1 = `${x + size * Math.cos(angle - Math.PI / 6)},${y + size * Math.sin(angle - Math.PI / 6)}`;
            const p2 = `${el.x2},${el.y2}`;
            const p3 = `${x + size * Math.cos(angle + Math.PI / 6)},${y + size * Math.sin(angle + Math.PI / 6)}`;
            return `${p1} ${p2} ${p3}`;
        },
        
        editTextElement(el) {
            if (this.readonly) return;
            const newText = prompt('Edit text:', el.text);
            if (newText !== null) {
                el.text = newText;
                this.$dispatch('whiteboard:element-updated', { element: el });
            }
        },
        
        startDrag(event, el) {
            if (this.readonly) return;
            const rect = this.$refs.canvas.getBoundingClientRect();
            this.dragTarget = el;
            this.dragOffset = { x: event.clientX - rect.left - el.x, y: event.clientY - rect.top - el.y };
        },
        
        getElements() {
            return this.elements;
        },
    }));
});
</script>

<style>
.gsmui-whiteboard {
    @apply font-sans;
}

.gsmui-whiteboard [x-cloak] {
    display: none !important;
}
</style>
