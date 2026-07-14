@blaze(fold: true)

@props([
    'galleries' => [
        // 2D Galleries - Grid
        ['id' => 'grid-1', 'name' => 'Classic Grid', 'category' => 'Grid', 'type' => '2D', 'desc' => 'Basic responsive image grid with hover zoom effects.'],
        ['id' => 'grid-2', 'name' => 'Overlay Grid', 'category' => 'Grid', 'type' => '2D', 'desc' => 'Grid with colorful overlay and icon on hover.'],
        ['id' => 'grid-3', 'name' => 'Shadow Grid', 'category' => 'Grid', 'type' => '2D', 'desc' => 'Grid with shadow and gradient caption overlay.'],
        ['id' => 'grid-4', 'name' => 'Numbered Grid', 'category' => 'Grid', 'type' => '2D', 'desc' => 'Grid with numbered badges on each image.'],
        
        // 2D Galleries - Masonry
        ['id' => 'masonry-1', 'name' => 'CSS Masonry', 'category' => 'Masonry', 'type' => '2D', 'desc' => 'CSS columns-based masonry layout with zoom hover.'],
        ['id' => 'masonry-2', 'name' => 'Action Masonry', 'category' => 'Masonry', 'type' => '2D', 'desc' => 'Masonry with like and zoom action buttons.'],
        ['id' => 'masonry-3', 'name' => 'Category Masonry', 'category' => 'Masonry', 'type' => '2D', 'desc' => 'Masonry with category tags and slide-up overlay.'],
        ['id' => 'masonry-4', 'name' => 'Social Masonry', 'category' => 'Masonry', 'type' => '2D', 'desc' => 'Masonry with social metrics and tilted hover.'],
        
        // 2D Galleries - Carousel
        ['id' => 'carousel-1', 'name' => 'Basic Carousel', 'category' => 'Carousel', 'type' => '2D', 'desc' => 'Horizontal carousel with navigation arrows and dots.'],
        ['id' => 'carousel-2', 'name' => 'Thumb Carousel', 'category' => 'Carousel', 'type' => '2D', 'desc' => 'Multi-image carousel with thumbnail navigation.'],
        ['id' => 'carousel-3', 'name' => '3D Carousel', 'category' => 'Carousel', 'type' => '3D', 'desc' => '3D perspective carousel with rotating cards.'],
        ['id' => 'carousel-4', 'name' => 'Ken Burns', 'category' => 'Carousel', 'type' => '2D', 'desc' => 'Carousel with Ken Burns zoom animation effect.'],
        
        // 2D Galleries - Lightbox
        ['id' => 'lightbox-1', 'name' => 'Basic Lightbox', 'category' => 'Lightbox', 'type' => '2D', 'desc' => 'Lightbox with overlay zoom and keyboard navigation.'],
        ['id' => 'lightbox-2', 'name' => 'Swipe Lightbox', 'category' => 'Lightbox', 'type' => '2D', 'desc' => 'Lightbox with touch swipe gesture support.'],
        ['id' => 'lightbox-3', 'name' => 'Info Lightbox', 'category' => 'Lightbox', 'type' => '2D', 'desc' => 'Lightbox with sidebar info panel.'],
        ['id' => 'lightbox-4', 'name' => 'Fullscreen Lightbox', 'category' => 'Lightbox', 'type' => '2D', 'desc' => 'Lightbox with fullscreen mode toggle.'],
        
        // 2D Galleries - Justified
        ['id' => 'justified-1', 'name' => 'Basic Justified', 'category' => 'Justified', 'type' => '2D', 'desc' => 'Justified layout with consistent row heights.'],
        ['id' => 'justified-2', 'name' => 'Overlap Justified', 'category' => 'Justified', 'type' => '2D', 'desc' => 'Justified with overlapping image effect.'],
        ['id' => 'justified-3', 'name' => 'Border Justified', 'category' => 'Justified', 'type' => '2D', 'desc' => 'Justified with accent border colors on hover.'],
        ['id' => 'justified-4', 'name' => 'Action Justified', 'category' => 'Justified', 'type' => '2D', 'desc' => 'Justified with zoom and download action buttons.'],
        
        // 2D Galleries - Magazine
        ['id' => 'magazine-1', 'name' => 'Hero Magazine', 'category' => 'Magazine', 'type' => '2D', 'desc' => 'Magazine layout with featured hero image.'],
        ['id' => 'magazine-2', 'name' => 'Collage Magazine', 'category' => 'Magazine', 'type' => '2D', 'desc' => 'Magazine collage with overlapping rotated cards.'],
        ['id' => 'magazine-3', 'name' => 'Grid Magazine', 'category' => 'Magazine', 'type' => '2D', 'desc' => 'Magazine grid with text overlay blocks.'],
        ['id' => 'magazine-4', 'name' => 'Scroll Magazine', 'category' => 'Magazine', 'type' => '2D', 'desc' => 'Magazine with horizontal scroll sections.'],
        
        // 2D Galleries - Puzzle
        ['id' => 'puzzle-1', 'name' => 'Interlock Puzzle', 'category' => 'Puzzle', 'type' => '2D', 'desc' => 'Puzzle layout with interlocking image pieces.'],
        ['id' => 'puzzle-2', 'name' => 'Hexagon Puzzle', 'category' => 'Puzzle', 'type' => '2D', 'desc' => 'Puzzle with hexagonal cutout shapes.'],
        ['id' => 'puzzle-3', 'name' => 'Diamond Puzzle', 'category' => 'Puzzle', 'type' => '2D', 'desc' => 'Puzzle with diamond-shaped rotated images.'],
        ['id' => 'puzzle-4', 'name' => 'Circle Mosaic', 'category' => 'Puzzle', 'type' => '2D', 'desc' => 'Puzzle with circular mosaic arrangement.'],
        
        // 2D Galleries - Stack
        ['id' => 'stack-1', 'name' => 'Fan Stack', 'category' => 'Stack', 'type' => '2D', 'desc' => 'Stacked cards with fan spread effect.'],
        ['id' => 'stack-2', 'name' => 'Horizontal Stack', 'category' => 'Stack', 'type' => '2D', 'desc' => 'Horizontal carousel stack with depth scaling.'],
        ['id' => 'stack-3', 'name' => 'Vertical Stack', 'category' => 'Stack', 'type' => '2D', 'desc' => 'Vertical stack with stagger animation.'],
        ['id' => 'stack-4', 'name' => 'Depth Stack', 'category' => 'Stack', 'type' => '2D', 'desc' => 'Stacked gallery with layered shadow depth.'],
        
        // 3D Galleries - Parallax
        ['id' => 'parallax-1', 'name' => 'Mouse Parallax', 'category' => 'Parallax', 'type' => '3D', 'desc' => 'Parallax with mouse-tracking depth effect.'],
        ['id' => 'parallax-2', 'name' => 'Scroll Parallax', 'category' => 'Parallax', 'type' => '3D', 'desc' => 'Parallax scrolling with layered depth.'],
        ['id' => 'parallax-3', 'name' => 'Tilt Parallax', 'category' => 'Parallax', 'type' => '3D', 'desc' => 'Parallax with 3D perspective tilt transforms.'],
        ['id' => 'parallax-4', 'name' => 'Floating Parallax', 'category' => 'Parallax', 'type' => '3D', 'desc' => 'Floating images with multiple depth layers.'],
        
        // 3D Galleries - Perspective
        ['id' => 'perspective-1', 'name' => 'Vanishing Point', 'category' => 'Perspective', 'type' => '3D', 'desc' => 'Perspective gallery with vanishing point effect.'],
        ['id' => 'perspective-2', 'name' => 'Card Flip', 'category' => 'Perspective', 'type' => '3D', 'desc' => 'Perspective with card flip reveal on hover.'],
        ['id' => 'perspective-3', 'name' => 'Isometric', 'category' => 'Perspective', 'type' => '3D', 'desc' => 'Isometric view with rotated perspective.'],
        ['id' => 'perspective-4', 'name' => 'Zoom Tunnel', 'category' => 'Perspective', 'type' => '3D', 'desc' => 'Perspective zoom tunnel with scroll depth.'],
        
        // 3D Galleries - Cube
        ['id' => 'cube-1', 'name' => 'Auto Cube', 'category' => 'Cube', 'type' => '3D', 'desc' => 'Rotating 3D cube with auto-animation.'],
        ['id' => 'cube-2', 'name' => 'Manual Cube', 'category' => 'Cube', 'type' => '3D', 'desc' => '3D cube with manual rotation controls.'],
        ['id' => 'cube-3', 'name' => 'Unfold Cube', 'category' => 'Cube', 'type' => '3D', 'desc' => '3D cube with unfolding animation.'],
        ['id' => 'cube-4', 'name' => 'Drag Cube', 'category' => 'Cube', 'type' => '3D', 'desc' => '3D cube with interactive drag rotation.'],
        
        // 3D Galleries - Tilt
        ['id' => 'tilt-1', 'name' => 'Glare Tilt', 'category' => 'Tilt', 'type' => '3D', 'desc' => 'Tilt with mouse tracking and glare effect.'],
        ['id' => 'tilt-2', 'name' => 'Shine Tilt', 'category' => 'Tilt', 'type' => '3D', 'desc' => 'Tilt with directional shine sweep.'],
        ['id' => 'tilt-3', 'name' => 'Shadow Tilt', 'category' => 'Tilt', 'type' => '3D', 'desc' => 'Tilt with dynamic depth shadow.'],
        ['id' => 'tilt-4', 'name' => 'Neon Tilt', 'category' => 'Tilt', 'type' => '3D', 'desc' => 'Tilt with neon glow border effect.'],
        
        // 3D Galleries - Depth
        ['id' => 'depth-1', 'name' => 'Layer Parallax', 'category' => 'Depth', 'type' => '3D', 'desc' => 'Depth with layered parallax on scroll.'],
        ['id' => 'depth-2', 'name' => 'Float Depth', 'category' => 'Depth', 'type' => '3D', 'desc' => 'Depth with floating card layers.'],
        ['id' => 'depth-3', 'name' => 'Focus Depth', 'category' => 'Depth', 'type' => '3D', 'desc' => 'Depth with z-focus blur effect.'],
        ['id' => 'depth-4', 'name' => 'Isometric Depth', 'category' => 'Depth', 'type' => '3D', 'desc' => 'Depth with isometric layered cards.'],
        
        // 3D Galleries - Flip
        ['id' => 'flip-1', 'name' => 'Card Flip', 'category' => 'Flip', 'type' => '3D', 'desc' => '3D card flip with front/back panels.'],
        ['id' => 'flip-2', 'name' => 'Split Flip', 'category' => 'Flip', 'type' => '3D', 'desc' => 'Split horizontal flip effect.'],
        ['id' => 'flip-3', 'name' => 'Panel Fold', 'category' => 'Flip', 'type' => '3D', 'desc' => 'Multi-panel fold transition.'],
        ['id' => 'flip-4', 'name' => 'Accordion Fold', 'category' => 'Flip', 'type' => '3D', 'desc' => 'Accordion strip fold animation.'],
        
        // 4D/Animated Galleries - Morphing
        ['id' => 'morph-1', 'name' => 'Shape Morph', 'category' => 'Morphing', 'type' => '4D', 'desc' => 'Shape-shifting border morph on hover.'],
        ['id' => 'morph-2', 'name' => 'Blob Morph', 'category' => 'Morphing', 'type' => '4D', 'desc' => 'Blob-shaped continuous morph animation.'],
        ['id' => 'morph-3', 'name' => 'Liquid Morph', 'category' => 'Morphing', 'type' => '4D', 'desc' => 'SVG liquid distortion effect.'],
        ['id' => 'morph-4', 'name' => 'Meta Morph', 'category' => 'Morphing', 'type' => '4D', 'desc' => 'Metamorphosis between different shapes.'],
        
        // 4D/Animated Galleries - Particle
        ['id' => 'particle-1', 'name' => 'Dissolve Particles', 'category' => 'Particle', 'type' => '4D', 'desc' => 'Image dissolves into particles on hover.'],
        ['id' => 'particle-2', 'name' => 'Float Particles', 'category' => 'Particle', 'type' => '4D', 'desc' => 'Floating particle overlay effect.'],
        ['id' => 'particle-3', 'name' => 'Constellation', 'category' => 'Particle', 'type' => '4D', 'desc' => 'Constellation effect connecting images.'],
        ['id' => 'particle-4', 'name' => 'Pixelate', 'category' => 'Particle', 'type' => '4D', 'desc' => 'Pixelation dissolve effect.'],
        
        // 4D/Animated Galleries - Wave
        ['id' => 'wave-1', 'name' => 'Flow Wave', 'category' => 'Wave', 'type' => '4D', 'desc' => 'Flowing wave animation background.'],
        ['id' => 'wave-2', 'name' => 'Ripple Wave', 'category' => 'Wave', 'type' => '4D', 'desc' => 'Click ripple effect on images.'],
        ['id' => 'wave-3', 'name' => 'Border Wave', 'category' => 'Wave', 'type' => '4D', 'desc' => 'Ocean wave border animation.'],
        ['id' => 'wave-4', 'name' => 'Sound Wave', 'category' => 'Wave', 'type' => '4D', 'desc' => 'Sound wave visualization overlay.'],
        
        // 4D/Animated Galleries - Gravity
        ['id' => 'gravity-1', 'name' => 'Magnetic', 'category' => 'Gravity', 'type' => '4D', 'desc' => 'Magnetic attraction effect on hover.'],
        ['id' => 'gravity-2', 'name' => 'Falling Cards', 'category' => 'Gravity', 'type' => '4D', 'desc' => 'Falling cards with bounce animation.'],
        ['id' => 'gravity-3', 'name' => 'Orbit', 'category' => 'Gravity', 'type' => '4D', 'desc' => 'Images orbiting around center.'],
        ['id' => 'gravity-4', 'name' => 'Magnetic Grid', 'category' => 'Gravity', 'type' => '4D', 'desc' => 'Magnetic grid distortion effect.'],
        
        // 4D/Animated Galleries - Floating
        ['id' => 'floating-1', 'name' => 'Angel Float', 'category' => 'Floating', 'type' => '4D', 'desc' => 'Angel-like floating with glow particles.'],
        ['id' => 'floating-2', 'name' => 'Levitate', 'category' => 'Floating', 'type' => '4D', 'desc' => 'Levitation effect with shadow scaling.'],
        ['id' => 'floating-3', 'name' => 'Ethereal', 'category' => 'Floating', 'type' => '4D', 'desc' => 'Ethereal mist background effect.'],
        ['id' => 'floating-4', 'name' => 'Wing Expand', 'category' => 'Floating', 'type' => '4D', 'desc' => 'Wing-like hover expansion.'],
        
        // 4D/Animated Galleries - Carved
        ['id' => 'carved-1', 'name' => 'Stone Carve', 'category' => 'Carved', 'type' => '4D', 'desc' => 'Stone/chisel carved texture effect.'],
        ['id' => 'carved-2', 'name' => 'Emboss', 'category' => 'Carved', 'type' => '4D', 'desc' => 'Embossed/relief surface effect.'],
        ['id' => 'carved-3', 'name' => 'Ornate Frame', 'category' => 'Carved', 'type' => '4D', 'desc' => 'Wood/leather ornate frame effect.'],
        ['id' => 'carved-4', 'name' => 'Chrome Finish', 'category' => 'Carved', 'type' => '4D', 'desc' => 'Metallic/chrome finish effect.'],
    ],
])

@php
    $categories = $galleries->groupBy('category');
    $types = $galleries->groupBy('type');
@endphp

<div {{ $attributes->class('min-h-screen bg-zinc-50 dark:bg-zinc-900') }}>
    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-zinc-200 dark:border-white/10 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-lg">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <div>
                <h1 class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro Image Gallery</h1>
                <p class="text-sm text-zinc-500">{{ count($galleries) }} gallery variants across {{ count($categories) }} categories</p>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-3 py-1 text-xs font-medium text-blue-700 dark:text-blue-300">{{ count($galleries) }} Variants</span>
                <span class="rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-3 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300">{{ count($categories) }} Categories</span>
                <span class="rounded-full bg-violet-100 dark:bg-violet-900/30 px-3 py-1 text-xs font-medium text-violet-700 dark:text-violet-300">2D / 3D / 4D</span>
            </div>
        </div>
        {{-- Type Navigation --}}
        <div class="border-t border-zinc-200 dark:border-white/10 overflow-x-auto">
            <div class="mx-auto flex max-w-7xl gap-2 px-6 py-2 text-xs font-medium">
                @foreach($types as $type => $items)
                    <a href="#type-{{ strtolower($type) }}" class="shrink-0 rounded-full px-3 py-1.5 bg-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-100 dark:bg-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-900/30 text-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-700 dark:text-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-300 hover:opacity-80 transition-all">
                        {{ $type }} ({{ count($items) }})
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-12 space-y-16">
        {{-- By Type --}}
        @foreach($types as $type => $items)
            <section id="type-{{ strtolower($type) }}">
                <div class="mb-8 flex items-center gap-3">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-100 dark:bg-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-900/30 text-lg font-bold text-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-600 dark:text-{{ $type === '2D' ? 'blue' : ($type === '3D' ? 'purple' : 'pink') }}-400">{{ $type }}</span>
                    <div>
                        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $type }} Galleries</h2>
                        <p class="text-sm text-zinc-500">{{ count($items) }} variants</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    @foreach($items as $gallery)
                        <div class="group" id="gallery-{{ $gallery['id'] }}">
                            <div class="mb-3 flex items-center justify-between">
                                <div>
                                    <span class="inline-block rounded-full bg-zinc-200 dark:bg-zinc-700 px-2.5 py-0.5 text-xs font-medium text-zinc-600 dark:text-zinc-400">{{ $gallery['category'] }}</span>
                                    <h3 class="mt-1 text-lg font-semibold text-zinc-900 dark:text-white">{{ $gallery['name'] }}</h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $gallery['desc'] }}</p>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-zinc-400">
                                    <code class="rounded-md bg-zinc-100 dark:bg-zinc-800 px-2 py-1 font-mono">gsmui::image-gallery.{{ $gallery['id'] }}</code>
                                </div>
                            </div>
                            <div class="overflow-hidden rounded-2xl border border-zinc-200 dark:border-white/10 bg-white dark:bg-zinc-800 shadow-sm">
                                <div class="p-4">
                                    <p class="text-xs text-zinc-400 mb-2">Preview placeholder — use with <code class="bg-zinc-100 dark:bg-zinc-700 px-1 rounded">&lt;x-gsmui::image-gallery.{{ $gallery['id'] }} :$images /&gt;</code></p>
                                    <div class="grid grid-cols-3 gap-2 rounded-lg bg-zinc-100 dark:bg-zinc-700 p-4">
                                        @for($i = 0; $i < 6; $i++)
                                            <div class="aspect-square rounded-lg bg-gradient-to-br from-zinc-200 to-zinc-300 dark:from-zinc-600 dark:to-zinc-500 flex items-center justify-center text-xs text-zinc-400">
                                                {{ $i + 1 }}
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach

        {{-- Footer --}}
        <footer class="border-t border-zinc-200 dark:border-white/10 pt-12 pb-8 text-center">
            <p class="text-lg font-bold text-zinc-900 dark:text-white">Gsmui Pro — {{ count($galleries) }} Image Gallery Components</p>
            <p class="mt-2 text-sm text-zinc-500">2D · 3D · 4D Effects · Interactive · Dark Mode Ready · Tailwind CSS</p>
            <p class="mt-1 text-xs text-zinc-400">Use <code class="rounded bg-zinc-200 dark:bg-zinc-700 px-1.5 py-0.5 text-xs font-mono">&lt;x-gsmui::image-gallery.{variant} /&gt;</code></p>
        </footer>
    </main>
</div>
