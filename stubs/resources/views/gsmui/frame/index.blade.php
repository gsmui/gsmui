@php
/**
 * Frame Components Index
 * 
 * A collection of 100 unique frame components built with Tailwind CSS.
 * Use individual components via: <x-gsmui::frame.component-name />
 */

$categories = [
    'Basic Frames' => [
        ['file' => 'iframe', 'name' => 'iFrame', 'description' => 'Embedded iframe with customizable sandbox settings'],
        ['file' => 'angle', 'name' => 'Angle Frame', 'description' => 'Frame with angled corners for dynamic look'],
        ['file' => 'shave', 'name' => 'Shave Frame', 'description' => 'Frame with shaved/rounded edges'],
        ['file' => 'circular', 'name' => 'Circular Frame', 'description' => 'Perfect circle frame for avatars and icons'],
        ['file' => 'outline', 'name' => 'Outline Frame', 'description' => 'Simple outline border frame'],
        ['file' => 'shadow', 'name' => 'Shadow Frame', 'description' => 'Frame with customizable shadow depth'],
        ['file' => 'solid-border', 'name' => 'Solid Border', 'description' => 'Frame with solid border styling'],
    ],
    'Modern Effects' => [
        ['file' => 'glass', 'name' => 'Glass Frame', 'description' => 'Frosted glass effect with backdrop blur'],
        ['file' => 'glass-morphism', 'name' => 'Glass Morphism', 'description' => 'Modern glassmorphism design'],
        ['file' => 'frosted-glass', 'name' => 'Frosted Glass', 'description' => 'Frosted glass with transparency'],
        ['file' => 'neumorphic', 'name' => 'Neumorphic', 'description' => 'Soft UI neumorphism design'],
        ['file' => 'claymorphism', 'name' => 'Claymorphism', 'description' => '3D clay-like appearance'],
        ['file' => 'aero', 'name' => 'Aero', 'description' => 'Windows Aero-inspired glass effect'],
        ['file' => 'minimalist', 'name' => 'Minimalist', 'description' => 'Clean, minimal design'],
    ],
    'Animated Frames' => [
        ['file' => 'neon', 'name' => 'Neon Frame', 'description' => 'Glowing neon border effect'],
        ['file' => 'glow-on-hover', 'name' => 'Glow on Hover', 'description' => 'Neon glow effect on hover'],
        ['file' => 'glow-border', 'name' => 'Glow Border', 'description' => 'Animated glowing border'],
        ['file' => 'border-animate', 'name' => 'Border Animate', 'description' => 'Animated border rotation'],
        ['file' => 'gradient-border-animated', 'name' => 'Gradient Border', 'description' => 'Animated gradient border'],
        ['file' => 'scan-line', 'name' => 'Scan Line', 'description' => 'CRT-style scan line effect'],
        ['file' => 'shimmer', 'name' => 'Shimmer', 'description' => 'Shimmer loading animation'],
        ['file' => 'pulse-border', 'name' => 'Pulse Border', 'description' => 'Pulsating border animation'],
        ['file' => 'breathing', 'name' => 'Breathing', 'description' => 'Breathing scale animation'],
        ['file' => 'gradient', 'name' => 'Gradient', 'description' => 'Animated gradient background'],
    ],
    '3D Effects' => [
        ['file' => '3d', 'name' => '3D Frame', 'description' => 'Perspective 3D transform effect'],
        ['file' => 'card-3d', 'name' => 'Card 3D', 'description' => '3D card flip and tilt effect'],
        ['file' => 'isometric', 'name' => 'Isometric', 'description' => 'Isometric 3D perspective'],
        ['file' => 'layered', 'name' => 'Layered', 'description' => 'Stacked layer effect'],
        ['file' => 'stacked', 'name' => 'Stacked', 'description' => 'Multiple stacked cards'],
        ['file' => 'floating', 'name' => 'Floating', 'description' => 'Floating animation effect'],
        ['file' => 'tilted', 'name' => 'Tilted', 'description' => 'Tilted perspective frame'],
    ],
    'Hover Effects' => [
        ['file' => 'hover-lift', 'name' => 'Hover Lift', 'description' => 'Lifts up on hover'],
        ['file' => 'rotate-on-hover', 'name' => 'Rotate on Hover', 'description' => 'Rotates on hover'],
        ['file' => 'scale-on-hover', 'name' => 'Scale on Hover', 'description' => 'Scales up on hover'],
        ['file' => 'blur-on-hover', 'name' => 'Blur on Hover', 'description' => 'Blurs background on hover'],
        ['file' => 'grayscale-on-hover', 'name' => 'Grayscale on Hover', 'description' => 'Grayscale filter on hover'],
        ['file' => 'opacity-on-hover', 'name' => 'Opacity on Hover', 'description' => 'Opacity change on hover'],
    ],
    'Cutouts & Shapes' => [
        ['file' => 'cutout', 'name' => 'Cutout', 'description' => 'Frame with cutout corners'],
        ['file' => 'clip-path', 'name' => 'Clip Path', 'description' => 'Custom clip-path shapes'],
        ['file' => 'mask-image', 'name' => 'Mask Image', 'description' => 'Image mask effects'],
        ['file' => 'text-mask', 'name' => 'Text Mask', 'description' => 'Text-based mask effect'],
        ['file' => 'diagonal-cut', 'name' => 'Diagonal Cut', 'description' => 'Diagonal edge cut'],
        ['file' => 'triangle-corner', 'name' => 'Triangle Corner', 'description' => 'Triangle corner decoration'],
        ['file' => 'peeling-corner', 'name' => 'Peeling Corner', 'description' => 'Peeling page corner effect'],
        ['file' => 'curved-edge', 'name' => 'Curved Edge', 'description' => 'Curved edge styling'],
    ],
    'Decorative Frames' => [
        ['file' => 'polaroid', 'name' => 'Polaroid', 'description' => 'Classic polaroid photo frame'],
        ['file' => 'polaroid-instant', 'name' => 'Polaroid Instant', 'description' => 'Instant camera style frame'],
        ['file' => 'ornate', 'name' => 'Ornate', 'description' => 'Ornate decorative frame'],
        ['file' => 'ornate-baroque', 'name' => 'Ornate Baroque', 'description' => 'Baroque style ornate frame'],
        ['file' => 'diploma', 'name' => 'Diploma', 'description' => 'Certificate/diploma style frame'],
        ['file' => 'ribbon', 'name' => 'Ribbon', 'description' => 'Frame with ribbon decoration'],
        ['file' => 'ribbon-badge', 'name' => 'Ribbon Badge', 'description' => 'Ribbon badge corner'],
        ['file' => 'badge-corner', 'name' => 'Badge Corner', 'description' => 'Corner badge decoration'],
        ['file' => 'embossed', 'name' => 'Embossed', 'description' => 'Embossed/raised effect'],
        ['file' => 'double-border', 'name' => 'Double Border', 'description' => 'Double border frame'],
    ],
    'Border Styles' => [
        ['file' => 'dotted-border', 'name' => 'Dotted Border', 'description' => 'Dotted border style'],
        ['file' => 'dashed-border', 'name' => 'Dashed Border', 'description' => 'Dashed border style'],
        ['file' => 'striped', 'name' => 'Striped', 'description' => 'Striped border pattern'],
        ['file' => 'stamp-edge', 'name' => 'Stamp Edge', 'description' => 'Postage stamp edge effect'],
    ],
    'Themed Frames' => [
        ['file' => 'cyberpunk', 'name' => 'Cyberpunk', 'description' => 'Futuristic cyberpunk style'],
        ['file' => 'retro', 'name' => 'Retro', 'description' => 'Retro/vintage style'],
        ['file' => 'brutalist', 'name' => 'Brutalist', 'description' => 'Brutalist design style'],
        ['file' => 'tech', 'name' => 'Tech', 'description' => 'Technology-inspired frame'],
        ['file' => 'elegant', 'name' => 'Elegant', 'description' => 'Elegant, refined style'],
        ['file' => 'industrial', 'name' => 'Industrial', 'description' => 'Industrial/mechanical style'],
        ['file' => 'skeuomorphic', 'name' => 'Skeuomorphic', 'description' => 'Realistic material simulation'],
    ],
    'Material Frames' => [
        ['file' => 'wooden', 'name' => 'Wooden', 'description' => 'Wood texture frame'],
        ['file' => 'metallic', 'name' => 'Metallic', 'description' => 'Metallic shine effect'],
        ['file' => 'velvet', 'name' => 'Velvet', 'description' => 'Velvet texture frame'],
        ['file' => 'marble', 'name' => 'Marble', 'description' => 'Marble texture frame'],
        ['file' => 'stone', 'name' => 'Stone', 'description' => 'Stone texture frame'],
    ],
    'Vintage Frames' => [
        ['file' => 'crt-monitor', 'name' => 'CRT Monitor', 'description' => 'Old CRT monitor style'],
        ['file' => 'cassette-tape', 'name' => 'Cassette Tape', 'description' => 'Cassette tape frame'],
        ['file' => 'vhs-tape', 'name' => 'VHS Tape', 'description' => 'VHS tape style frame'],
        ['file' => 'scroll', 'name' => 'Scroll', 'description' => 'Ancient scroll frame'],
        ['file' => 'chalkboard', 'name' => 'Chalkboard', 'description' => 'Chalkboard/slate frame'],
        ['file' => 'whiteboard', 'name' => 'Whiteboard', 'description' => 'Whiteboard frame'],
        ['file' => 'cork-board', 'name' => 'Cork Board', 'description' => 'Cork bulletin board'],
    ],
    'Creative Frames' => [
        ['file' => 'gallery-wall', 'name' => 'Gallery Wall', 'description' => 'Gallery wall arrangement'],
        ['file' => 'gallery-mat', 'name' => 'Gallery Mat', 'description' => 'Matted gallery frame'],
        ['file' => 'photo-border', 'name' => 'Photo Border', 'description' => 'Classic photo border'],
        ['file' => 'ticket', 'name' => 'Ticket', 'description' => 'Ticket/event style frame'],
        ['file' => 'postcard', 'name' => 'Postcard', 'description' => 'Postcard style frame'],
        ['file' => 'sticky-note', 'name' => 'Sticky Note', 'description' => 'Sticky note frame'],
        ['file' => 'name-tag', 'name' => 'Name Tag', 'description' => 'Name tag style frame'],
        ['file' => 'clipboard', 'name' => 'Clipboard', 'description' => 'Clipboard frame'],
        ['file' => 'memo-clip', 'name' => 'Memo Clip', 'description' => 'Memo with clip decoration'],
        ['file' => 'projector-screen', 'name' => 'Projector Screen', 'description' => 'Projector screen frame'],
        ['file' => 'canvas-wrap', 'name' => 'Canvas Wrap', 'description' => 'Wrapped canvas frame'],
        ['file' => 'shadow-box', 'name' => 'Shadow Box', 'description' => 'Shadow box display frame'],
    ],
    'Optical Frames' => [
        ['file' => 'magnifying-glass', 'name' => 'Magnifying Glass', 'description' => 'Magnifying glass effect'],
        ['file' => 'telescope', 'name' => 'Telescope', 'description' => 'Telescope view frame'],
        ['file' => 'binoculars', 'name' => 'Binoculars', 'description' => 'Binocular view frame'],
        ['file' => 'spotlight', 'name' => 'Spotlight', 'description' => 'Spotlight focus effect'],
        ['file' => 'vignette', 'name' => 'Vignette', 'description' => 'Vignette edge effect'],
    ],
    'Special Effects' => [
        ['file' => 'portal', 'name' => 'Portal', 'description' => 'Portal/portal effect'],
        ['file' => 'punch-card', 'name' => 'Punch Card', 'description' => 'Old punch card style'],
        ['file' => 'wire-frame', 'name' => 'Wire Frame', 'description' => 'Wireframe outline style'],
        ['file' => 'ledger-book', 'name' => 'Ledger Book', 'description' => 'Accounting ledger style'],
    ],
];

$totalComponents = 0;
foreach ($categories as $components) {
    $totalComponents += count($components);
}
@endphp

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-900" x-data="frameIndex()">
    <header class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Frame Components</h1>
            <span class="px-3 py-1 bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400 text-sm font-medium rounded-full">
                <span x-text="filteredCount">0</span> / {{ $totalComponents }} Components
            </span>
        </div>
    </header>

    <main class="p-6 max-w-7xl mx-auto">
        <!-- Search and Filter Section -->
        <div class="mb-8 space-y-4">
            <!-- Search Input -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    x-model="searchQuery" 
                    @input="filterComponents()"
                    placeholder="Search frames by name, description, or category..." 
                    class="block w-full pl-10 pr-10 py-3 text-base border border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200"
                >
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button 
                        x-show="searchQuery.length > 0" 
                        @click="clearSearch()" 
                        class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Category Filters -->
            <div class="flex flex-wrap gap-2">
                <button 
                    @click="setCategory('all')" 
                    :class="selectedCategory === 'all' ? 'bg-purple-600 text-white' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 hover:border-purple-300 dark:hover:border-purple-700'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                >
                    All Frames
                </button>
                @foreach($categories as $category => $components)
                <button 
                    @click="setCategory('{{ $category }}')" 
                    :class="selectedCategory === '{{ $category }}' ? 'bg-purple-600 text-white' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 hover:border-purple-300 dark:hover:border-purple-700'"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                >
                    {{ $category }} <span class="ml-1 text-xs opacity-70">({{ count($components) }})</span>
                </button>
                @endforeach
            </div>

            <!-- Active Filters -->
            <div x-show="searchQuery.length > 0 || selectedCategory !== 'all'" class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400">
                <span>Active filters:</span>
                <span x-show="searchQuery.length > 0" class="px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded">
                    Search: "<span x-text="searchQuery"></span>"
                </span>
                <span x-show="selectedCategory !== 'all'" class="px-2 py-1 bg-zinc-100 dark:bg-zinc-700 rounded">
                    Category: <span x-text="selectedCategory"></span>
                </span>
                <button @click="clearAllFilters()" class="text-purple-600 dark:text-purple-400 hover:underline ml-2">Clear all</button>
            </div>
        </div>

        <!-- No Results Message -->
        <div x-show="filteredCount === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-white">No frames found</h3>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                Try adjusting your search or filter criteria.
            </p>
            <button @click="clearAllFilters()" class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                Clear all filters
            </button>
        </div>

        <!-- Components Grid -->
        <div class="space-y-8" x-show="filteredCount > 0">
            @foreach($categories as $category => $components)
            <div x-show="selectedCategory === 'all' || selectedCategory === '{{ $category }}'">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400 text-sm font-bold">
                        {{ count($components) }}
                    </span>
                    {{ $category }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($components as $component)
                    <div 
                        x-show="matchesFilter('{{ $component['name'] }}', '{{ $component['description'] }}', '{{ $category }}', '{{ $component['file'] }}')"
                        class="p-4 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-purple-300 dark:hover:border-purple-700 hover:shadow-lg transition-all duration-200 group"
                    >
                        <div class="flex items-start justify-between mb-2">
                            <h3 class="font-medium text-zinc-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400">
                                {{ $component['name'] }}
                            </h3>
                            <span class="text-zinc-400 group-hover:text-purple-500 transition-colors">→</span>
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $component['description'] }}
                        </p>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-zinc-400 dark:text-zinc-500 font-mono">
                                &lt;x-gsmui::frame.{{ $component['file'] }} /&gt;
                            </p>
                            <button 
                                @click="copyUsage('{{ $component['file'] }}')" 
                                class="text-xs text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors"
                            >
                                <span x-text="copiedComponent === '{{ $component['file'] }}' ? '✓ Copied' : 'Copy'"></span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Usage Section -->
        <div class="mt-12 p-6 bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">Usage</h2>
            <div class="bg-zinc-100 dark:bg-zinc-900 rounded-lg p-4 font-mono text-sm">
                <p class="text-zinc-600 dark:text-zinc-400"># Include a specific frame component</p>
                <p class="text-zinc-900 dark:text-white">&lt;x-gsmui::frame.polaroid&gt;</p>
                <p class="text-zinc-900 dark:text-white">&nbsp;&nbsp;&lt;img src="photo.jpg" alt="Photo" /&gt;</p>
                <p class="text-zinc-900 dark:text-white">&lt;/x-gsmui::frame.polaroid&gt;</p>
                <br>
                <p class="text-zinc-600 dark:text-zinc-400"># Or use the index to browse all components</p>
                <p class="text-zinc-900 dark:text-white">@include('gsmui::frame.index')</p>
            </div>
        </div>
    </main>
</div>

<script>
function frameIndex() {
    return {
        searchQuery: '',
        selectedCategory: 'all',
        filteredCount: {{ $totalComponents }},
        copiedComponent: null,
        
        filterComponents() {
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        },
        
        matchesFilter(name, description, category, file) {
            const query = this.searchQuery.toLowerCase();
            
            // Category filter
            if (this.selectedCategory !== 'all' && this.selectedCategory !== category) {
                return false;
            }
            
            // Search filter
            if (query.length > 0) {
                const searchableText = `${name} ${description} ${category} ${file}`.toLowerCase();
                return searchableText.includes(query);
            }
            
            return true;
        },
        
        setCategory(category) {
            this.selectedCategory = category;
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        },
        
        clearSearch() {
            this.searchQuery = '';
            this.filterComponents();
        },
        
        clearAllFilters() {
            this.searchQuery = '';
            this.selectedCategory = 'all';
            this.$nextTick(() => {
                let count = 0;
                document.querySelectorAll('[x-show^="matchesFilter"]').forEach(el => {
                    const style = window.getComputedStyle(el);
                    if (style.display !== 'none') {
                        count++;
                    }
                });
                this.filteredCount = count;
            });
        },
        
        copyUsage(file) {
            const usage = `<x-gsmui::frame.${file} />\n    <img src="..." alt="..." />\n</x-gsmui::frame.${file}>`;
            navigator.clipboard.writeText(usage);
            this.copiedComponent = file;
            setTimeout(() => this.copiedComponent = null, 2000);
        }
    }
}
</script>
